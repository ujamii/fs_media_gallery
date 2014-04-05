<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Mediagallery',
	'Media Gallery'
);

$pluginSignature = strtolower($extensionName) . '_mediagallery';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_gallery.xml');


if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 * @todo: create backend module to order albums
	 */
//	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
//		'MiniFranske.' . $_EXTKEY,
//		'web',	 // Make module a submodule of 'web'
//		'mediagallery',	// Submodule key
//		'',						// Position
//		array(
//			'MediaGallery' => 'list, new, create, update, edit, delete',
//			'MediaAlbum' => 'list, new, create, update, edit, delete',
//
//		),
//		array(
//			'access' => 'user,group',
//			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
//			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mediagallery.xlf',
//		)
//	);

	// Adding click menu item:
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'MiniFranske\\FsMediaGallery\\Service\\ClickMenuOptions',
		'path' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Service/ClickMenuOptions.php'
	);
}

// Add MediaGallery folder type and icon
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon(
	'pages',
	'contains-mediagal', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery.png'
);
\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon(
	'sys_file_collection',
	'folder', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery.png'
);

\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(array(
	'edit-album' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery-edit.png',
	'add-album' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery-add.png'
), 'fs_media_gallery');

// Add module icon for Folder
$TCA['pages']['columns']['module']['config']['items'][] = array(
	'MediaGalleries',
	'mediagal',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery.png'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Media Gallery');
