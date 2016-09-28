<?php
defined('TYPO3_MODE') || die();

$boot = function ($packageKey) {

    if (TYPO3_MODE === 'BE') {
        // Adding click menu item:
        $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
            'name' => 'MiniFranske\\FsMediaGallery\\Service\\ClickMenuOptions'
        );

        // Add CSH
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tt_content.pi_flexform.fsmediagallery_mediagallery.list',
            'EXT:' . $packageKey . '/Resources/Private/Language/locallang_csh_flexforms.xlf'
        );
    }

    if (class_exists('TYPO3\\CMS\\Core\\Imaging\\IconRegistry')) {
        // Initiate
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'apps-pagetree-folder-contains-mediagal',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            array(
                'source' => 'EXT:' . $packageKey . '/Resources/Public/Icons/mediagallery.svg',
            )
        );
        $iconRegistry->registerIcon(
            'tcarecords-sys_file_collection-folder',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            array(
                'source' => 'EXT:' . $packageKey . '/Resources/Public/Icons/mediagallery.svg',
            )
        );
        $iconRegistry->registerIcon(
            'action-edit-album',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            array(
                'source' => 'EXT:' . $packageKey . '/Resources/Public/Icons/mediagallery-edit.svg',
            )
        );
        $iconRegistry->registerIcon(
            'action-add-album',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            array(
                'source' => 'EXT:' . $packageKey . '/Resources/Public/Icons/mediagallery-add.svg',
            )
        );
        $iconRegistry->registerIcon(
            'content-mediagallery',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            array(
                'source' => 'EXT:' . $packageKey . '/Resources/Public/Icons/mediagallery_ce_wiz.png',
            )
        );
        $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-mediagal'] =
            'apps-pagetree-folder-contains-mediagal';

    // Fallback for < 7.6
    } else {
        \TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon(
            'pages',
            'contains-mediagal',
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/mediagallery.png'
        );
        \TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon(
            'sys_file_collection',
            'folder',
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/mediagallery.png'
        );

        \TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(array(
            'edit-album' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/mediagallery-edit.png',
            'add-album' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/mediagallery-add.png'
        ), 'fs_media_gallery');
    }

    // Add module icon for Folder
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
        'MediaGalleries',
        'mediagal',
        'EXT:fs_media_gallery/Resources/Public/Icons/mediagallery.png'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $packageKey,
        'Configuration/TypoScript',
        'Media Gallery'
    );
    // Add Theme 'Bootstrap3'
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $packageKey,
        'Configuration/TypoScript/Themes/Bootstrap3',
        'Media Gallery Theme \'Bootstrap3\''
    );

    // Show albums in page module
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['sys_file_collection'][0] = [
        'fList' => 'title, datetime, parentalbum, main_asset',
        'icon' => true
    ];
};
$boot($_EXTKEY);
unset($boot);
