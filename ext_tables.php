<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Mediagallery',
	'Media Gallery'
);


$pluginSignature = strtolower($extensionName) . '_mediagallery';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_gallery.xml');


if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
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
		'path' => t3lib_extMgm::extPath($_EXTKEY).'Classes/Service/ClickMenuOptions.php'
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

// Add module icon for Folder
$TCA['pages']['columns']['module']['config']['items'][] = array(
	'MediaGalleries',
	'mediagal',
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/mediagallery.png'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Media Gallery');

?>