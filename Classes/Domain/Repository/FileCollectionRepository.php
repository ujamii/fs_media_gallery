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
	 * @param integer $pid
	 * @return NULL|\TYPO3\CMS\Core\Collection\AbstractRecordCollection[]
	 */
	public function findByStorageAndFolder($storageUid, $folder, $pid = NULL) {
		$conditions = array(
			'`storage`=' . $this->getDatabase()->fullQuoteStr($storageUid, $this->table),
			'`folder`=' . $this->getDatabase()->fullQuoteStr($folder, $this->table),
			'`type`=' . $this->getDatabase()->fullQuoteStr('folder', $this->table),
		);

		if ($pid !== NULL) {
			$conditions[] = 'pid='.intval($pid);
		}

		return $this->queryMultipleRecords($conditions);
	}
}