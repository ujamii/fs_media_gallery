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
class MediaGallery extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Description
	 *
	 * @var \string
	 */
	protected $description;

	/**
	 * Media Albums
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum>
	 * @lazy
	 */
	protected $mediaGalleryAlbums;

	/**
	 * __construct
	 *
	 * @return MediaGallery
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->mediaGalleryAlbums = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

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
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Adds a MediaAlbum
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaGalleryAlbum
	 * @return void
	 */
	public function addMediaGalleryAlbum(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaGalleryAlbum) {
		$this->mediaGalleryAlbums->attach($mediaGalleryAlbum);
	}

	/**
	 * Removes a MediaAlbum
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaGalleryAlbumToRemove The MediaAlbum to be removed
	 * @return void
	 */
	public function removeMediaGalleryAlbum(\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum $mediaGalleryAlbumToRemove) {
		$this->mediaGalleryAlbums->detach($mediaGalleryAlbumToRemove);
	}

	/**
	 * Returns the mediaGalleryAlbums
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum> $mediaGalleryAlbums
	 */
	public function getMediaGalleryAlbums() {
		return $this->mediaGalleryAlbums;
	}

	/**
	 * Sets the mediaGalleryAlbums
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MiniFranske\FsMediaGallery\Domain\Model\MediaAlbum> $mediaGalleryAlbums
	 * @return void
	 */
	public function setMediaGalleryAlbums(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mediaGalleryAlbums) {
		$this->mediaGalleryAlbums = $mediaGalleryAlbums;
	}

}
?>