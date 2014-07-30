<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MiniFranske.' . $_EXTKEY,
	'Mediagallery',
	array(
		'MediaAlbum' => 'show,showImage,showAlbum,showAlbumByConfig,list,random',
	),
	// non-cacheable actions
	array(
		'MediaAlbum' => 'random',
	)
);

// ModWizard config
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/ModWizards.ts">');

// Resource Icon hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_iconworks.php']['overrideResourceIcon']['FsMediaGallery'] =
	'MiniFranske\\FsMediaGallery\\Hooks\\IconUtilityHook';

// Add mediagallery icon to docheader of filelist
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/template.php']['docHeaderButtonsHook']['FsMediaGallery'] =
	'MiniFranske\\FsMediaGallery\\Hooks\\DocHeaderButtonsHook->addMediaGalleryButton';

// refresh file tree after changen in media album recored (sys_file_collection)
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
	'MiniFranske\\FsMediaGallery\\Hooks\\ProcessDatamapHook';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
	'MiniFranske\\FsMediaGallery\\Hooks\\ProcessDatamapHook';

// Real Url AutoConfiguration
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration'][$_EXTKEY] =
	'EXT:' . $_EXTKEY . '/Classes/Hooks/RealUrlAutoConfiguration.php:MiniFranske\FsMediaGallery\Hooks\RealUrlAutoConfiguration->addNewsConfig';


\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFolderMove,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'preFolderMove'
);
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PostFolderMove,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'postFolderMove'
);
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFolderDelete,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'preFolderDelete'
);
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PostFolderDelete,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'postFolderDelete'
);
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PreFolderRename,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'preFolderRename'
);
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher')->connect(
	'TYPO3\\CMS\\Core\\Resource\\ResourceStorage',
	\TYPO3\CMS\Core\Resource\ResourceStorageInterface::SIGNAL_PostFolderRename,
	'MiniFranske\\FsMediaGallery\\Hooks\\FolderChangedSlot',
	'postFolderRename'
);
