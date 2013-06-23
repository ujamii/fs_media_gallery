<?php
namespace MiniFranske\FsMediaGallery\ViewHelpers\Widget;

class PaginateViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Widget\PaginateViewHelper {


	/**
	 * @var \MiniFranske\FsMediaGallery\ViewHelpers\Widget\Controller\PaginateController
	 */
	protected $controller;

	/**
	 * @param \MiniFranske\FsMediaGallery\ViewHelpers\Widget\Controller\PaginateController $controller
	 * @return void
	 */
	public function injectController(\MiniFranske\FsMediaGallery\ViewHelpers\Widget\Controller\PaginateController $controller) {
		$this->controller = $controller;
	}

	/**
	 * main render function
	 *
	 * @param array/objects $objects
	 * @param string $as
	 * @param array $configuration
	 * @return string the content
	 */
	public function render($objects, $as, array $configuration = array('itemsPerPage' => 10, 'insertAbove' => FALSE, 'insertBelow' => TRUE, 'maximumNumberOfLinks' => 99)) {

		return $this->initiateSubRequest();
	}

}