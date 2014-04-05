<?php

namespace MiniFranske\FsMediaGallery\Domain\Repository;

/**
 * Class FileCollectionRepository
 *
 * @package MiniFranske\FsMediaGallery\Domain\Repository
 */
class FileCollectionRepository extends \TYPO3\CMS\Core\Resource\FileCollectionRepository {

	/**
	 * Find all storagecollections bases of storageUid, folder and optional pid
	 *
	 * @param integer $storageUid
	 * @param string $folder
	 * @param NULL|array|integer $pids
	 * @return NULL|\TYPO3\CMS\Core\Collection\AbstractRecordCollection[]
	 */
	public function findByStorageAndFolder($storageUid, $folder, $pids = NULL) {
		$conditions = array(
			'`storage`=' . $this->getDatabaseConnection()->fullQuoteStr($storageUid, $this->table),
			'`folder`=' . $this->getDatabaseConnection()->fullQuoteStr($folder, $this->table),
			'`type`=' . $this->getDatabaseConnection()->fullQuoteStr('folder', $this->table),
		);

		if (is_int($pids)) {
			$conditions[] = 'pid='.intval($pids);
		} elseif (is_array($pids)) {
			foreach ($pids as $pid) {
				$conditions[] = 'pid IN ('.implode(',', $pids).') ';
			}
		}

		return $this->queryMultipleRecords($conditions);
	}
}