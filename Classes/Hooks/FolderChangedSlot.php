<?php
namespace MiniFranske\FsMediaGallery\Hooks;

/***************************************************************
 *  Copyright notice
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Slots that pick up signals after (re)moving folders to update mediagallery record (sys_file_collection)
 */
class FolderChangedSlot implements \TYPO3\CMS\Core\SingletonInterface
{

    protected $folderMapping = array();

    /**
     * @var \MiniFranske\FsMediaGallery\Service\Utility
     */
    protected $utilityService;

    /**
     * mediaAlbumRepository
     *
     * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaAlbumRepository
     * @inject
     */
    protected $mediaAlbumRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * __contruct
     */
    public function __construct()
    {
        $this->utilityService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('MiniFranske\\FsMediaGallery\\Service\\Utility');
    }

    /**
     * Get sub folder structure of folder before is gets moved
     * Is needed to update sys_file_collection records when move was successful
     *
     * @param Folder $folder
     * @param Folder $targetFolder
     * @param string $newName
     */
    public function preFolderMove(Folder $folder, Folder $targetFolder, $newName)
    {
        $this->folderMapping[$folder->getCombinedIdentifier()] = $this->getSubFolderIdentifiers($folder);
    }

    /**
     * Update sys_file_collection records when folder is moved
     *
     * @param Folder $folder
     * @param Folder $targetFolder
     * @param string $newName
     */
    public function postFolderMove(Folder $folder, Folder $targetFolder, $newName)
    {
        $newFolder = $targetFolder->getSubfolder($newName);
        $oldStorageUid = $folder->getStorage()->getUid();
        $newStorageUid = $newFolder->getStorage()->getUid();

        $this->utilityService->updateFolderRecord(
            $oldStorageUid,
            $folder->getIdentifier(),
            $newStorageUid,
            $newFolder->getIdentifier()
        );

        if (!empty($this->folderMapping[$folder->getCombinedIdentifier()])) {
            $newMapping = $this->getSubFolderIdentifiers($newFolder);
            foreach ($this->folderMapping[$folder->getCombinedIdentifier()] as $key => $folderInfo) {
                $this->utilityService->updateFolderRecord(
                    $oldStorageUid,
                    $folderInfo[1],
                    $newStorageUid,
                    $newMapping[$key][1]
                );
            }
        }
    }

    /**
     * Get sub folder structure of folder before is gets deleted
     * Is needed to update sys_file_collection records when delete was successful
     *
     * @param Folder $folder
     */
    public function preFolderDelete(Folder $folder)
    {
        $this->folderMapping[$folder->getCombinedIdentifier()] = $this->getSubFolderIdentifiers($folder);
    }

    /**
     * Update sys_file_collection records when folder is deleted
     *
     * @param Folder $folder
     */
    public function postFolderDelete(Folder $folder)
    {
        $storageUid = $folder->getStorage()->getUid();
        $this->utilityService->deleteFolderRecord($storageUid, $folder->getIdentifier());
        foreach ($this->folderMapping[$folder->getCombinedIdentifier()] as $folderInfo) {
            $this->utilityService->deleteFolderRecord($storageUid, $folderInfo[1]);
        }
        $this->utilityService->clearMediaGalleryPageCache();
    }

    /**
     * Get sub folder structure of folder before is gets renamed
     * Is needed to update sys_file_collection records when renaming was successful
     *
     * @param Folder $folder
     * @param $newName
     */
    public function preFolderRename(Folder $folder, $newName)
    {
        $this->folderMapping[$folder->getCombinedIdentifier()] = $this->getSubFolderIdentifiers($folder);
    }

    /**
     * Update sys_file_collection records when a folder is renamed
     *
     * @param Folder $folder
     * @param string $newName
     */
    public function postFolderRename(Folder $folder, $newName)
    {
        $newFolder = $folder->getParentFolder()->getSubfolder($newName);
        $oldStorageUid = $folder->getStorage()->getUid();
        $newStorageUid = $newFolder->getStorage()->getUid();

        $this->utilityService->updateFolderRecord(
            $oldStorageUid,
            $folder->getIdentifier(),
            $newStorageUid,
            $newFolder->getIdentifier()
        );

        if (!empty($this->folderMapping[$folder->getCombinedIdentifier()])) {
            $newMapping = $this->getSubFolderIdentifiers($newFolder);
            foreach ($this->folderMapping[$folder->getCombinedIdentifier()] as $key => $folderInfo) {
                $this->utilityService->updateFolderRecord(
                    $oldStorageUid,
                    $folderInfo[1],
                    $newStorageUid,
                    $newMapping[$key][1]
                );
            }
            $this->utilityService->clearMediaGalleryPageCache();
        }
    }

    /**
     * Auto creates a file collection to the first parentCollection found of the current folder, when no collection is
     * fount nothing is created
     *
     * @param Folder $folder
     */
    public function postFolderAdd(Folder $folder)
    {
        $mediaFolders = $this->utilityService->getStorageFolders();
        if (count($mediaFolders)) {
            foreach ($mediaFolders as $uid => $title) {
                $parents = $this->getFirstParentCollections($folder, $uid);
                if (count($parents)) {
                    //take the first parent found
                    $parentUid = $parents[0]['uid'];
                    $this->utilityService->createFolderRecord(
                        ucfirst(trim(str_replace('_', ' ', $folder->getName()))),
                        $uid,
                        $folder->getStorage()->getUid(),
                        $folder->getIdentifier(),
                        $parentUid
                    );
                    $this->utilityService->clearMediaGalleryPageCache();
                }
            }
        }
    }

    /**
     * Gets the first parentCollections of the given folder and mediaFolderUid(storagepid)
     *
     * @param Folder $folder
     * @param $mediaFolderUid
     * @return array|null
     */
    protected function getFirstParentCollections(Folder $folder, $mediaFolderUid)
    {
        $parentCollection = [];
        if ($folder->getParentFolder() == $folder) {
            return $parentCollection;
        } else {
            $parentCollection = $this->utilityService->findFileCollectionRecordsForFolder(
                $folder->getStorage()->getUid(),
                $folder->getParentFolder()->getIdentifier(),
                $mediaFolderUid
            );
            if (!count($parentCollection)) {
                $parentCollection = $this->getFirstParentCollections($folder->getParentFolder(), $mediaFolderUid);
            }
        }

        return $parentCollection;
    }

    /**
     * Get sub folder identifiers
     *
     * @param Folder $folder
     * @return array
     */
    protected function getSubFolderIdentifiers(Folder $folder)
    {
        $folderIdentifiers = array();
        foreach ($folder->getSubfolders() as $subFolder) {
            $folderIdentifiers[] = array($subFolder->getHashedIdentifier(), $subFolder->getIdentifier());
            $folderIdentifiers = array_merge($folderIdentifiers, $this->getSubFolderIdentifiers($subFolder));
        }

        return $folderIdentifiers;
    }

    /**
     * Set the respectStoragePage On False, otherwise no items are found when a storagepid is required
     *
     * @param Repository $repository
     * @param [] $pids
     */
    protected function setStoragePids(Repository $repository, $pids)
    {
        /** @var $querySettings Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setStoragePageIds($pids);
        $repository->setDefaultQuerySettings($querySettings);
    }

    /**
     * Persist all data that was not stored by now
     *
     * @return void
     */
    protected function persistAll()
    {
        $this->objectManager
            ->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')
            ->persistAll();
    }
}