<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Update class for the extension manager
 */
class ext_update
{

    /**
     * Array of flash messages (params) array[][status,title,message]
     *
     * @var array
     */
    protected $messageArray = [];

    /**
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->databaseConnection = $GLOBALS['TYPO3_DB'];
    }

    /**
     * Main update function called by the extension manager.
     *
     * @return string
     */
    public function main()
    {
        $this->updatePlugins();
        return $this->generateOutput();
    }

    /**
     * Called by the extension manager to determine if the update menu entry
     * should by showed.
     * Menu item does not exists anymore in 6.2 so default TRUE for now.
     *
     * @return bool
     */
    public function access()
    {
        return true;
    }

    /**
     * Migrate old (flexform) plugin values to new
     *
     * @return void
     */
    protected function updatePlugins()
    {

        // find all fs_media_gallery plugins
        $res = $this->databaseConnection->exec_SELECTquery('uid, pid, header, pi_flexform, pages, recursive',
            'tt_content',
            'CType=\'list\' AND list_type=\'fsmediagallery_mediagallery\' AND deleted = 0');

        /** @var \TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools $flexformTools */
        $flexformTools = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Configuration\\FlexForm\\FlexFormTools');

        $migrations = [
            [
                'old' => ['general', 'settings.mediaAlbums'],
                'new' => ['general', 'settings.mediaAlbumsUids']
            ],
            [
                'old' => ['general', 'settings.mediagalleries'],
                'new' => ['general', 'settings.mediaAlbumsUids']
            ],
            [
                'old' => ['album', 'settings.album.itemsPerPage'],
                'new' => ['list', 'settings.list.pagination.itemsPerPage']
            ],
            [
                'old' => ['album', 'settings.album.thumb.maxWidth'],
                'new' => ['list', 'settings.list.thumb.width']
            ],
            [
                'old' => ['album', 'settings.album.thumb.maxHeight'],
                'new' => ['list', 'settings.list.thumb.height']
            ],

            [
                'old' => ['image', 'settings.image.itemsPerPage'],
                'new' => ['album', 'settings.album.pagination.itemsPerPage']
            ],
            [
                'old' => ['image', 'settings.image.thumb.maxWidth'],
                'new' => ['album', 'settings.album.thumb.width']
            ],
            [
                'old' => ['image', 'settings.image.thumb.maxHeight'],
                'new' => ['album', 'settings.album.thumb.height']
            ],

            [
                'old' => ['image', 'settings.enableLightbox'],
                'new' => ['album', 'settings.album.lightbox.enable']
            ],
            [
                'old' => ['random', 'settings.galleryPid'],
                'new' => ['random', 'settings.random.targetPid']
            ],

            [
                'old' => ['random', 'settings.random.thumb.maxWidth'],
                'new' => ['random', 'settings.random.thumb.width']
            ],
            [
                'old' => ['random', 'settings.random.thumb.maxHeight'],
                'new' => ['random', 'settings.random.thumb.height']
            ],

            [
                'old' => ['image', 'settings.image.maxWidth'],
                'new' => ['detail', 'settings.detail.asset.width']
            ],
            [
                'old' => ['image', 'settings.image.maxHeight'],
                'new' => ['detail', 'settings.detail.asset.height']
            ],
        ];

        while ($row = $this->databaseConnection->sql_fetch_assoc($res)) {
            $title = 'Update plugin "' . htmlspecialchars($row['header']) . '" pid: ' . $row['pid'] . ' uid: ' . $row['uid'];
            $update = false;

            $xmlArray = GeneralUtility::xml2array($row['pi_flexform']);
            if (!is_array($xmlArray) || !isset($xmlArray['data'])) {
                $status = FlashMessage::WARNING;
                $message = 'No Flexform data for plugin';
            } else {

                $message = 'Migrate Flexform values: <br />';
                $status = FlashMessage::OK;
                $foundFlexformFields = 0;

                foreach ($migrations as $migration) {
                    if (isset($xmlArray['data'][$migration['old'][0]]['lDEF'][$migration['old'][1]]['vDEF'])) {
                        $foundFlexformFields++;
                        $message .= ' * [' . $migration['old'][0] . '] ' . $migration['old'][1] . ' -> [' . $migration['new'][0] . '] ' . $migration['new'][1];

                        // check if new already exists
                        if (!empty($xmlArray['data'][$migration['new'][0]]['lDEF'][$migration['new'][1]]['vDEF'])) {
                            $status = FlashMessage::WARNING;
                            $message .= ' <strong>New value already present (skipped property)</strong>';

                            // create new value and clear old
                        } else {
                            $xmlArray['data'][$migration['new'][0]]['lDEF'][$migration['new'][1]]['vDEF'] = $xmlArray['data'][$migration['old'][0]]['lDEF'][$migration['old'][1]]['vDEF'];
                            unset($xmlArray['data'][$migration['old'][0]]['lDEF'][$migration['old'][1]]);
                            $update = true;
                        }
                        $message .= '<br />';
                    }
                }

                // Move pages to startingpoint in flexform
                if ($row['pages'] && empty($xmlArray['data']['general']['lDEF']['settings.startingpoint']['vDEF'])) {
                    $foundFlexformFields++;
                    $xmlArray['data']['general']['lDEF']['settings.startingpoint']['vDEF'] = $row['pages'];
                    $row['pages'] = '';
                    $message .= ' * tt_content.pages -> [genaral] settings.startingpoint<br />';
                    $update = true;
                }

                // Move recursive to flexform
                if ($row['recursive'] && !isset($xmlArray['data']['general']['lDEF']['settings.recursive']['vDEF'])) {
                    $foundFlexformFields++;
                    $xmlArray['data']['general']['lDEF']['settings.recursive']['vDEF'] = $row['pages'];
                    $row['recursive'] = 0;
                    $message .= ' * tt_content.recursive -> [genaral] settings.recursive<br />';
                    $update = true;
                }

                if (!$foundFlexformFields) {
                    $message = '<em>No flexform fields found that need to be updated</em><br />';
                }

                if ($update) {
                    $this->databaseConnection->exec_UPDATEquery('tt_content', 'uid=' . $row['uid'], [
                        'pages' => $row['pages'],
                        'recursive' => $row['recursive'],
                        'pi_flexform' => $flexformTools->flexArray2Xml($xmlArray)
                    ]);
                    $message .= '<br /><strong>Plugin updated</strong>';

                } else {
                    $message .= '<br /><strong><em>Plugin is not updated</em></strong>';
                }

                //$message .= '<pre>' . print_r($xmlArray, 1) . '</pre>';
            }

            $this->messageArray[] = [$status, $title, $message];
        }
    }

    /**
     * Generates output by using flash messages
     *
     * @return string
     */
    protected function generateOutput()
    {
        $output = '';
        foreach ($this->messageArray as $messageItem) {
            /** @var \TYPO3\CMS\Core\Messaging\FlashMessage $flashMessage */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                $messageItem[2],
                $messageItem[1],
                $messageItem[0]);
            $output .= '<p>' . $flashMessage->__toString() . '</p>';
        }
        return $output;
    }

}
