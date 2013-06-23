<?php
namespace MiniFranske\FsMediaGallery\ViewHelpers\Widget\Controller;

class PaginateController extends \TYPO3\CMS\Fluid\ViewHelpers\Widget\Controller\PaginateController {

	/**
	 * @param integer $currentPage
	 * @return void
	 */
	public function indexAction($currentPage = 1) {
		// set current page
		$this->currentPage = (integer) $currentPage;
		if ($this->currentPage < 1) {
			$this->currentPage = 1;
		}
		if ($this->currentPage > $this->numberOfPages) {
			// set $modifiedObjects to NULL if the page does not exist
			$modifiedObjects = NULL;
		} else {
			// modify query
			$itemsPerPage = (integer) $this->configuration['itemsPerPage'];
			if(is_a($this->objects, '\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult')){
				$query = $this->objects->getQuery();
				$query->setLimit($itemsPerPage);
				if ($this->currentPage > 1) {
					$query->setOffset((integer)($itemsPerPage * ($this->currentPage - 1)));
				}
				$modifiedObjects = $query->execute();
			}else{
				$offset = 0;
				if ($this->currentPage > 1) {
					$offset = ((integer)($itemsPerPage * ($this->currentPage - 1)));
				}
				if(is_array($this->objects)) {
					$modifiedObjects = array_slice($this->objects, $offset, (integer)$this->configuration['itemsPerPage']);
				} else {
					$modifiedObjects = array_slice($this->objects->toArray(), $offset, (integer)$this->configuration['itemsPerPage']);
				}
			}
		}
		$this->view->assign('contentArguments', array(
			$this->widgetConfiguration['as'] => $modifiedObjects
		));
		$this->view->assign('configuration', $this->configuration);
		$this->view->assign('pagination', $this->buildPagination());
	}
}
