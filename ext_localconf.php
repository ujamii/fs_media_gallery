<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MiniFranske.' . $_EXTKEY,
	'Mediagallery',
	array(
		'MediaGallery' => 'list, random, showAlbums',
		'MediaAlbum' => 'show, showImage',

	),
	// non-cacheable actions
	array(
	)
);

?>