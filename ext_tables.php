<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Mediagallery',
	'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:mediagallery.title'
);

$pluginSignature = strtolower($extensionName) . '_mediagallery';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_mediaalbum.xml');


if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 * @todo: create backend module to order albums
	 */

	// Adding click menu item:
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'MiniFranske\\FsMediaGallery\\Service\\ClickMenuOptions'
	);

	// Add CSH
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'tt_content.pi_flexform.' . $pluginSignature . '.list', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_flexforms.xlf');
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
// Add Theme 'Bootstrap3'
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Themes/Bootstrap3', 'Media Gallery Theme \'Bootstrap3\'');
