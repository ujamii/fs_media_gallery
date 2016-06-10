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
    'uploadfolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '1.2.6',
    'constraints' => array(
        'depends' => array(
            'php' => '5.5',
            'typo3' => '6.2.14 - 7.6.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
