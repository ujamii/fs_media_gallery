<?php
namespace MiniFranske\FsMediaGallery\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Frans Saris <franssaris@gmail.com>
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

/**
 *
 *
 * @package fs_media_gallery
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class MediaAlbum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {


	/**
	 * fileCollectionRepository
	 *
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 * @inject
	 * @lazy
	 */
	protected $fileCollectionRepository;

	/**
	 * @var array
	 */
	protected $assets;

	/**
	 * Title
	 *
	 * @var \string
	 */
	protected $title;

	/**
	 * Description visible online
	 *
	 * @var \string
	 */
	protected $webdescription;

	/**
	 * @var \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum
	 * @lazy
	 */
	protected $parentalbum;

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the webdescription
	 *
	 * @return \string $webdescription
	 */
	public function getWebdescription() {
		return $this->webdescription;
	}

	/**
	 * Sets the webdescription
	 *
	 * @param \string $webdescription
	 * @return void
	 */
	public function setWebdescription($webdescription) {
		$this->webdescription = $webdescription;
	}

	/**
	 * Set parentalbum
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $parentalbum
	 */
	public function setParentalbum(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $parentalbum) {
		$this->parentalbum = $parentalbum;
	}

	/**
	 * Get parentalbum
	 *
	 * @return \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum
	 */
	public function getParentalbum() {
		return $this->parentalbum;
	}

	/**
	 * @return array<\TYPO3\CMS\Core\Resource\File>
	 */
	public function getAssets() {
		if($this->assets === NULL) {
			/** @var $fileCollection \TYPO3\CMS\Core\Resource\Collection\AbstractFileCollection */
			$fileCollection = $this->fileCollectionRepository->findByUid($this->getUid());
			$fileCollection->loadContents();
			$this->assets = $fileCollection->getItems();
		}

		return $this->assets;
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function getRandomAsset() {
		return $this->getAssets()[rand(0,count($this->getAssets()))];
	}
}
?>