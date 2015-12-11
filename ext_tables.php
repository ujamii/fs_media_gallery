<?php
defined('TYPO3_MODE') || die();

$boot = function ($packageKey) {

    $extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($packageKey);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $packageKey,
        'Mediagallery',
        'LLL:EXT:' . $packageKey . '/Resources/Private/Language/locallang_be.xlf:mediagallery.title'
    );

    $pluginSignature = strtolower($extensionName) . '_mediagallery';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
        'FILE:EXT:' . $packageKey . '/Configuration/FlexForms/flexform_mediaalbum.xml');

    if (TYPO3_MODE === 'BE') {

        // Adding click menu item:
        $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
            'name' => 'MiniFranske\\FsMediaGallery\\Service\\ClickMenuOptions'
        );

        // Add CSH
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tt_content.pi_flexform.' . $pluginSignature . '.list',
            'EXT:' . $packageKey . '/Resources/Private/Language/locallang_csh_flexforms.xlf');
    }

    // Add MediaGallery folder type and icon
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

    // Add module icon for Folder
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
        'MediaGalleries',
        'mediagal',
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($packageKey) . 'Resources/Public/Icons/mediagallery.png'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($packageKey, 'Configuration/TypoScript',
        'Media Gallery');
    // Add Theme 'Bootstrap3'
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($packageKey,
        'Configuration/TypoScript/Themes/Bootstrap3', 'Media Gallery Theme \'Bootstrap3\'');

    // Show albums in page module
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['sys_file_collection'][0] = [
        'fList' => 'title, datetime, parentalbum, main_asset',
        'icon' => true
    ];
};
$boot($_EXTKEY);
unset($boot);