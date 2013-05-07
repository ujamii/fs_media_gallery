<?php
/*
 * This source file is proprietary property of Beech Applications B.V.
 * Date: 07-05-2013 22:03
 * All code (c) Beech Applications B.V. all rights reserved
 */

namespace MiniFranske\FsMediaGallery\Service;


class ClickMenuOptions {
	/**
	 * Adds a sample item to the CSM
	 *
	 * @param \TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject Back-reference to the calling object
	 * @param array $menuItems Current list of menu items
	 * @param string $table Name of the table the clicked on item belongs to
	 * @param integer $uid Id of the clicked on item
	 *
	 * @return array Modified list of menu items
	 */
	public function main(\TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject, $menuItems, $table, $uid) {
//
//		echo $table.':'.$uid.PHP_EOL;
//		print_r($menuItems);
//		print_r($parentObject);

		$menuItems[] = 'spacer';
		$menuItems['sys_file_collections'] = array(0 => '', 1 => $table.'::'.$uid);

		return $menuItems;
	}
}