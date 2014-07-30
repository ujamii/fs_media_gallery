<?php
namespace MiniFranske\FsMediaGallery\Utility;

/*                                                                        *
 * Inspired by Tx_News_Utility_Page                                       *
 *                                                                        *
 * This script is part of the TYPO3 project.                              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Page Utility class
 */
class PageUtility {

	/**
	 * Find all ids from given ids and level
	 *
	 * @param string $pidList comma separated list of ids
	 * @param integer $recursive recursive levels
	 * @return string comma separated list of ids
	 */
	public static function extendPidListByChildren($pidList = '', $recursive = 0) {
		$recursive = (int)$recursive;
		if ($recursive <= 0) {
			return $pidList;
		}

		/** @var $queryGenerator \TYPO3\CMS\Core\Database\QueryGenerator */
		$queryGenerator = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Database\\QueryGenerator');
		$recursiveStoragePids = array();
		$storagePids = GeneralUtility::intExplode(',', $pidList, TRUE);
		foreach ($storagePids as $startPid) {
			$pids = $queryGenerator->getTreeList($startPid, $recursive, 0, 1);
			if (strlen($pids) > 0) {
				$recursiveStoragePids[] = $pids;
			}
		}
		$recursiveStoragePids = implode(',', $recursiveStoragePids);
		return $recursiveStoragePids;
	}

}
