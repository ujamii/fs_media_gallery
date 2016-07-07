<?php
defined('TYPO3_MODE') || die();

$additionalColumns = array(
    'datetime' => array(
        'exclude' => 1,
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
            'rows' => 5,
            'eval' => 'trim',
            'wizards' => array(
                'RTE' => array(
                    'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                    'notNewRecords' => 1,
                    'RTEonly' => 1,
                    'module' => array(
                        'name' => 'wizard_rte',
                    ),
                    'title' => 'LLL:EXT:cms/locallang_ttc.:bodytext.W.RTE',
                    'type' => 'script'
                )
            )
        ),
        'defaultExtras' => 'richtext[]',
    ),
    'parentalbum' => array(
        'exclude' => 1,
        'l10n_mode' => 'exclude',
        'label' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.parentalbum',
        'config' => array(
            'type' => 'select',
            'renderType' => 'selectTree',
            'foreign_table' => 'sys_file_collection',
            'foreign_table_where' => ' AND (sys_file_collection.sys_language_uid = 0 OR sys_file_collection.l10n_parent = 0) AND sys_file_collection.pid = ###CURRENT_PID### AND sys_file_collection.uid != ###THIS_UID### ORDER BY sys_file_collection.sorting ASC, sys_file_collection.crdate DESC',
            'subType' => 'db',
            'treeConfig' => array(
                'parentField' => 'parentalbum',
                'appearance' => array(
                    'showHeader' => true,
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
    'main_asset' => array(
        'exclude' => 1,
        'l10n_mode' => 'mergeIfNotBlank',
        'label' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.main_asset',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'images',
            array(
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum.main_asset.add'
                ),
                'maxitems' => 1,
            ),
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        )
    )
);

foreach ($GLOBALS['TCA']['sys_file_collection']['types'] as $type => $tmp) {
    $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',--div--;LLL:EXT:fs_media_gallery/Resources/Private/Language/locallang_db.xlf:tx_fsmediagallery_domain_model_mediaalbum';
    // try to add field datetime before type (after title)
    if ($replacedTca = preg_replace('/(\s*)type(\s*)(;|,)/', 'datetime,type$3',
        $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'])
    ) {
        $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] = $replacedTca;
    } else {
        $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',datetime';
    }
    $GLOBALS['TCA']['sys_file_collection']['types'][$type]['showitem'] .= ',parentalbum,main_asset,webdescription';
}

// enable manual sorting
$GLOBALS['TCA']['sys_file_collection']['ctrl']['sortby'] = 'sorting';
$GLOBALS['TCA']['sys_file_collection']['ctrl']['default_sortby'] = 'ORDER BY sorting ASC, crdate DESC';

// enable main asset preview in list module
$GLOBALS['TCA']['sys_file_collection']['ctrl']['thumbnail'] = 'main_asset';

// Compatibility with 6.2
if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) < 7000000) {
    $$additionalColumns['webdescription']['config']['wizards']['RTE']['icon'] = 'wizard_rte2.gif';
}

\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['sys_file_collection']['columns'],
    $additionalColumns
);
