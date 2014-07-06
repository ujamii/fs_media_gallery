<?php
namespace MiniFranske\FsMediaGallery\Domain\Repository;

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

use MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum;

/**
 * MediaAlbumRepository
 */
class MediaAlbumRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * @var array default ordering
	 */
	protected $defaultOrderings = array(
		'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
		'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
	);

	/**
	 * Get random sub album
	 *
	 * @param MediaAlbum|bool $parent parent MediaAlbum, FALSE for parent = 0 or NULL for no restriction by parent
	 * @param array $filterByUids filter possible result by given uids
	 * @param bool $useAlbumFilterAsExclude
	 * @return MediaAlbum
	 */
	public function findRandom($parent = NULL, array $filterByUids = array(), $useAlbumFilterAsExclude = FALSE) {

		/** @var \TYPO3\CMS\Extbase\Persistence\Generic\Query $query */
		$query = $this->createQuery();
		$where = array();

		// restrict by parent album
		if ($parent !== NULL) {
			$where[] = 'parentalbum = ' . ($parent ? $parent->getUid() : 0);
		}

		// restrict by given uids
		if ($filterByUids !== array()) {
			$uids = array();
			foreach ($filterByUids as $uid) {
				$uids[] = (int)$uid;
			}
			$where[] = 'uid ' . ($useAlbumFilterAsExclude ? 'NOT ' : '') . 'IN (' . implode(',', $uids) . ')';
		}

		$statement = 'SELECT * FROM sys_file_collection WHERE ' .
			(count($where) ? implode(' AND ', $where) : '1=1') .
			$this->getWhereClauseForEnabledFields() .
			' ORDER BY RAND(NOW()) LIMIT 1';

		$query->statement($statement);
		$result = $query->execute();

		return $result->getFirst();
	}

	/**
	 * Find albums by parent album
	 *
	 * @param MediaAlbum $parentAlbum
	 * @param array $filterByUids filter possible result by given uids
	 * @param bool $useAlbumFilterAsExclude
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByParentAlbum(MediaAlbum $parentAlbum = NULL, array $filterByUids = array(), $useAlbumFilterAsExclude = FALSE) {
		$query = $this->createQuery();
		$constrains = array();
		$constrains[] = $query->equals('parentalbum', $parentAlbum ?: FALSE);
		if (count($filterByUids)) {
			if ($useAlbumFilterAsExclude) {
				$constrains[] = $query->logicalNot($query->in('uid', $filterByUids));
			} else {
				$constrains[] = $query->in('uid', $filterByUids);
			}
		}
		$query->matching($query->logicalAnd($constrains));

		return $query->execute();
	}

	/**
	 * get the WHERE clause for the enabled fields of this TCA table
	 * depending on the context
	 *
	 * @return string the additional where clause, something like " AND deleted=0 AND hidden=0"
	 */
	protected function getWhereClauseForEnabledFields() {
		if (TYPO3_MODE === 'FE' && $GLOBALS['TSFE']->sys_page) {
			// frontend context
			$whereClause = $GLOBALS['TSFE']->sys_page->enableFields('sys_file_collection');
			$whereClause .= $GLOBALS['TSFE']->sys_page->deleteClause('sys_file_collection');
		} else {
			// backend context
			$whereClause = \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields('sys_file_collection');
			$whereClause .= \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause('sys_file_collection');
		}
		return $whereClause;
	}

}