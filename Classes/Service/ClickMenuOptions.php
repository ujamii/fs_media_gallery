<?php
namespace MiniFranske\FsMediaGallery\Service;

/*
 * This source file is proprietary property of Beech Applications B.V.
 * Date: 07-05-2013 22:03
 * All code (c) Beech Applications B.V. all rights reserved
 */



class ClickMenuOptions {

	/**
	 * Add create sys_file_collection icon to filemenu
	 *
	 * @param \TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject Back-reference to the calling object
	 * @param array $menuItems Current list of menu items
	 * @param string $combinedIdentifier The combined identifier
	 * @param integer $uid Id of the clicked on item
	 *
	 * @return array Modified list of menu items
	 */
	public function main(\TYPO3\CMS\Backend\ClickMenu\ClickMenu $parentObject, $menuItems, $combinedIdentifier, $uid) {

		if (!$parentObject->isDBmenu) {
			$combinedIdentifier = rawurldecode($combinedIdentifier);
			/** @var $fileObject \TYPO3\CMS\Core\Resource\Folder */
			$folderObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()
				->retrieveFileOrFolderObject($combinedIdentifier);

			if ($folderObject && $folderObject instanceof \TYPO3\CMS\Core\Resource\Folder && in_array($folderObject->getRole(), array(\TYPO3\CMS\Core\Resource\Folder::ROLE_DEFAULT, \TYPO3\CMS\Core\Resource\Folder::ROLE_USERUPLOAD))) {

				// mediafolder id
				// @todo: find first page that contains
				$mediaPid = 2;

				/** @var $fileCollectionRepository \MiniFranske\FsMediaGallery\Domain\Repository\FileCollectionRepository */
				$fileCollectionRepository = new \MiniFranske\FsMediaGallery\Domain\Repository\FileCollectionRepository();
				$collections = $fileCollectionRepository->findByStorageAndFolder($folderObject->getStorage()->getUid(), $folderObject->getIdentifier(), $mediaPid);

				$menuItems[] = 'spacer';
				foreach ($collections as $collection) {
					$menuItems[] = $parentObject->linkItem(
						'Edit album "'.$collection->getTitle().'"',
						$parentObject->excludeIcon('<span class="t3-icon t3-icon-sys_file_collection-folder">&nbsp;</span>'),
						$parentObject->urlRefForCM("alt_doc.php?edit[sys_file_collection][".$collection->getUid()."]=edit", 'returnUrl')
					);
				}
				if(!count($collections)) {
					$menuItems[] = $parentObject->linkItem(
						'Create album',
						$parentObject->excludeIcon('<span class="t3-icon t3-icon-sys_file_collection-folder">&nbsp;</span>'),
						$parentObject->urlRefForCM("alt_doc.php?edit[sys_file_collection][".$mediaPid."]=new&defVals[sys_file_collection][title]=".ucfirst(trim(str_replace('_', ' ', $folderObject->getName())))."&defVals[sys_file_collection][storage]=".$folderObject->getStorage()->getUid()."&defVals[sys_file_collection][folder]=".$folderObject->getIdentifier()."&defVals[sys_file_collection][type]=folder", 'returnUrl')
					);
				}
			}
		}

		return $menuItems;
	}
}