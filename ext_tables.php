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
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_gallery.xml');


if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'MiniFranske.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'mediagallery',	// Submodule key
		'',						// Position
		array(
			'MediaGallery' => 'list, new, create, update, edit, delete',
			'MediaAlbum' => 'list, new, create, update, edit, delete',

		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mediagallery.xlf',
		)
	);

	// Adding click menu item:
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'MiniFranske\\FsMediaGallery\\Service\\ClickMenuOptions',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'Classes/Service/ClickMenuOptions.php'
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Media Gallery');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fsmediagallery_domain_model_mediagallery', 'EXT:fs_media_gallery/Resources/Private/Language/locallang_csh_tx_fsmediagallery_domain_model_mediagallery.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fsmediagallery_domain_model_mediagallery');
$TCA['tx_fsmediagallery_domain_model_mediagallery'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediagallery',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,media_gallery_albums,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/MediaGallery.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_fsmediagallery_domain_model_mediagallery.gif'
	),
);

$tmp_fs_media_gallery_columns = array(

	'title' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.title',
		'config' => array(
			'type' => 'input',
			'size' => 30,
			'eval' => 'trim'
		),
	),
	'webdescription' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.webdescription',
		'config' => array(
			'type' => 'text',
			'cols' => 40,
			'rows' => 15,
			'eval' => 'trim',
			'wizards' => array(
				'RTE' => array(
					'icon' => 'wizard_rte2.gif',
					'notNewRecords'=> 1,
					'RTEonly' => 1,
					'script' => 'wizard_rte.php',
					'title' => 'LLL:EXT:cms/locallang_ttc.:bodytext.W.RTE',
					'type' => 'script'
				)
			)
		),
		'defaultExtras' => 'richtext[]',
	),
);

t3lib_extMgm::addTCAcolumns('sys_file_collection',$tmp_fs_media_gallery_columns);


foreach($TCA['sys_file_collection']['types'] as $type => $tmp) {
	$TCA['sys_file_collection']['types']['showitem'] .= ',--div--;LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum,';
	$TCA['sys_file_collection']['types']['showitem'] .= 'title, webdescription';
}

?>