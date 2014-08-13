<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$additionalColumns = array(
	'datetime' => array(
		'exclude' => 0,
		'l10n_mode' => 'mergeIfNotBlank',
		'label' => 'LLL:EXT:cms/locallang_ttc.xlf:date_formlabel',
		'config' => array(
			'type' => 'input',
			'size' => 12,
			'max' => 20,
			'eval' => 'datetime',
		)
	),
	'sorting' => array(
		'label' => 'sorting',
		'config' => array(
			'type' => 'passthrough'
		)
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
					'notNewRecords' => 1,
					'RTEonly' => 1,
					'script' => 'wizard_rte.php',
					'title' => 'LLL:EXT:cms/locallang_ttc.:bodytext.W.RTE',
					'type' => 'script'
				)
			)
		),
		'defaultExtras' => 'richtext[]',
	),
	'parentalbum' => array(
		'exclude' => 0,
		'l10n_mode' => 'exclude',
		'label' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.parentalbum',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'sys_file_collection',
			'foreign_table_where' => ' AND (sys_file_collection.sys_language_uid = 0 OR sys_file_collection.l10n_parent = 0) AND sys_file_collection.pid = ###CURRENT_PID### AND sys_file_collection.uid != ###THIS_UID### ORDER BY sys_file_collection.sorting ASC, sys_file_collection.crdate DESC',
			'renderMode' => 'tree',
			'subType' => 'db',
			'treeConfig' => array(
				'parentField' => 'parentalbum',
				'appearance' => array(
					'showHeader' => TRUE,
					'maxLevels' => 99,
					'width' => 650,
				),
			),
			'size' => 10,
			'autoSizeMax' => 20,
			'minitems' => 0,
			'maxitems' => 1
		)
	),
);

foreach ($GLOBALS['TCA']['sys_file_collection']['types'] as $type => $tmp) {
	$GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',--div--;LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum';
	// try to add field datetime before type (after title)
	if ($replacedTca = preg_replace('/(\s*)type(\s*)(;|,)/', 'datetime,type$3', $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'])) {
		$GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] = $replacedTca;
	} else {
		$GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',datetime';
	}
	$GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',parentalbum,webdescription';
}

// enable manual sorting
$GLOBALS['TCA']['sys_file_collection']['ctrl']['sortby'] = 'sorting';
$GLOBALS['TCA']['sys_file_collection']['ctrl']['default_sortby'] = 'ORDER BY sorting ASC, crdate DESC';

\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA']['sys_file_collection']['columns'], $additionalColumns);
