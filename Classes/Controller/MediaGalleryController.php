<?php
namespace MiniFranske\FsMediaGallery\Controller;

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
class MediaGalleryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mediaGalleryRepository
	 *
	 * @var \MiniFranske\FsMediaGallery\Domain\Repository\MediaGalleryRepository
	 * @inject
	 */
	protected $mediaGalleryRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		// @todo remove pid restriction
		$mediaGalleries = $this->mediaGalleryRepository->findAll();
		$this->view->assign('mediaGalleries', $mediaGalleries);
	}

	/**
	 * action show
	 *
	 * @param \MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery
	 * @return void
	 */
	public function showAlbumsAction(\MiniFranske\FsMediaGallery\Domain\Model\MediaGallery $mediaGallery) {

		$this->view->assign('mediaGallery', $mediaGallery);
	}

	/**
	 * Show random image
	 *
	 * @return void
	 */
	public function randomImageAction() {

		return 'RANDOM';
	}


}
?>