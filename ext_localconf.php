<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MiniFranske.' . $_EXTKEY,
	'Mediagallery',
	array(
		'MediaAlbum' => 'list, show, random, showImage',

	),
	// non-cacheable actions
	array(
	)
);

?>