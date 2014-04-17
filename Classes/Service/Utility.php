<?php
namespace MiniFranske\FsMediaGallery\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


use \TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Utility class
 */
class Utility implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Get storage folders marked as media gallery
	 * @return array
	 */
	public function getStorageFolders() {
		$pages = array();

		if ($this->getBeUser()) {
			$res = $this->getDatabaseConnection()->exec_SELECTquery(
				'uid,title',
				'pages',
				'doktype = 254 AND module in (\'mediagal\')'. BackendUtility::deleteClause('pages'),
				'',
				'title'
			);
			while ($row = $this->getDatabaseConnection()->sql_fetch_assoc($res)){
				if(BackendUtility::readPageAccess($row['uid'], $this->getBeUser()->getPagePermsClause(1))){
					$pages[$row['uid']] = $row['title'];
				}
			}
		}
		return $pages;
	}

	/**
	 * Update file_collection record after move/rename folder
	 *
	 * @param int $oldStorageUid
	 * @param string $oldIdentifier
	 * @param int $newStorageUid
	 * @param string $newIdentifier
	 */
	public function updateFolderRecord($oldStorageUid, $oldIdentifier, $newStorageUid, $newIdentifier) {

		$this->getDatabaseConnection()->exec_UPDATEquery(
			'sys_file_collection',
			'storage = ' . (int)$oldStorageUid . '
			AND folder = ' . $this->getDatabaseConnection()->fullQuoteStr($oldIdentifier, 'sys_file_collection'),
			array(
				'storage' => $newStorageUid,
				'folder' => $newIdentifier
			),
			TRUE
		);
	}

	/**
	 * Delete file_collection when folder is deleted
	 *
	 * @param int $storageUid
	 * @param string $identifier
	 */
	public function deleteFolderRecord($storageUid, $identifier) {
		$this->getDatabaseConnection()->exec_UPDATEquery(
			'sys_file_collection',
			'storage = ' . (int)$storageUid . '
			AND folder = ' . $this->getDatabaseConnection()->fullQuoteStr($identifier, 'sys_file_collection'),
			array(
				'deleted' => 1
			)
		);
	}

	/**
	 * Find all storagecollections bases of storageUid, folder and optional pid
	 *
	 * @param integer $storageUid
	 * @param string $folder
	 * @param NULL|array|integer $pids
	 * @return array|NULL
	 */
	public function findFileCollectionRecordsForFolder($storageUid, $folder, $pids = NULL) {
		$conditions = array(
			'`storage`=' . $this->getDatabaseConnection()->fullQuoteStr($storageUid, 'sys_file_collection'),
			'`folder`=' . $this->getDatabaseConnection()->fullQuoteStr($folder, 'sys_file_collection'),
		);

		if (is_int($pids)) {
			$conditions[] = 'pid='.intval($pids);
		} elseif (is_array($pids)) {
			$conditions[] = 'pid IN ('.implode(',', $pids).') ';
		}
		$conditionsWhereClause = implode(' AND ', $conditions);

		return $this->getDatabaseConnection()->exec_SELECTgetRows(
			'uid,pid,title,type,hidden',
			'sys_file_collection',
			$conditionsWhereClause . BackendUtility::deleteClause('sys_file_collection')
		);
	}

	/**
	 * Gets the database connection object.
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
	 */
	protected function getBeUser() {
		return $GLOBALS['BE_USER'];
	}

}
