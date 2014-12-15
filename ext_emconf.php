<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "fs_media_gallery"
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Media Gallery',
	'description' => 'A media gallery based on the FAL integration of TYPO3.
Show your media assets from your local or remote storage as a gallery of albums.',
	'category' => 'plugin',
	'author' => 'Frans Saris',
	'author_email' => 'franssaris@gmail.com',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => FALSE,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => '1.0.2',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.2 - 7.99.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
