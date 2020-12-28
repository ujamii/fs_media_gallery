<?php

namespace MiniFranske\FsMediaGallery\ViewHelpers\Widget;


/*                                                                        *
	 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
	 *                                                                        *
	 * It is free software; you can redistribute it and/or modify it under    *
	 * the terms of the GNU Lesser General Public License, either version 3   *
	 *  of the License, or (at your option) any later version.                *
	 *                                                                        *
	 *                                                                        *
	 * This script is distributed in the hope that it will be useful, but     *
	 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
	 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
	 * General Public License for more details.                               *
	 *                                                                        *
	 * You should have received a copy of the GNU Lesser General Public       *
	 * License along with the script.                                         *
	 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
	 *                                                                        *
	 * The TYPO3 project - inspiring people to share!                         *
	 *                                                                        */

use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\RootNode;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInterface;
use TYPO3\CMS\Fluid\Core\Widget\AjaxWidgetContextHolder;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Fluid\Core\Widget\WidgetContext;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;
use TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException;
use TYPO3\CMS\Fluid\Core\Widget\WidgetRequest;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Extbase\Service\ExtensionService;
use TYPO3Fluid\Fluid\Core\Compiler\TemplateCompiler;
use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;

/**
 * @api
 */
abstract class AbstractWidgetViewHelper extends AbstractViewHelper implements ViewHelperInterface
{

    /**
     * The Controller associated to this widget.
     * This needs to be filled by the individual subclass by an `@TYPO3\CMS\Extbase\Annotation\Inject`
     * annotation.
     *
     * @var \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
     * @api
     */
    protected $controller;

    /**
     * If set to TRUE, it is an AJAX widget.
     *
     * @var boolean
     * @api
     */
    protected $ajaxWidget = false;

    /**
     * @var \TYPO3\CMS\Fluid\Core\Widget\AjaxWidgetContextHolder
     */
    private $ajaxWidgetContextHolder;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Service\ExtensionService
     */
    protected $extensionService;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var \TYPO3\CMS\Fluid\Core\Widget\WidgetContext
     */
    private $widgetContext;

    /**
     * @param \TYPO3\CMS\Fluid\Core\Widget\AjaxWidgetContextHolder $ajaxWidgetContextHolder
     * @return void
     */
    public function injectAjaxWidgetContextHolder(
        AjaxWidgetContextHolder $ajaxWidgetContextHolder
    )
    {
        $this->ajaxWidgetContextHolder = $ajaxWidgetContextHolder;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->widgetContext = $this->objectManager->get(WidgetContext::class);
    }

    /**
     * Initialize the arguments of the ViewHelper, and call the render() method of the ViewHelper.
     *
     * @return string the rendered ViewHelper.
     */
    public function initializeArgumentsAndRender()
    {
        $this->validateArguments();
        $this->initialize();
        $this->initializeWidgetContext();
        return $this->callRenderMethod();
    }

    /**
     * Initialize the Widget Context, before the Render method is called.
     *
     * @return void
     */
    private function initializeWidgetContext()
    {
        $this->widgetContext->setWidgetConfiguration($this->getWidgetConfiguration());
        $this->initializeWidgetIdentifier();
        $this->widgetContext->setControllerObjectName(get_class($this->controller));
        $extensionName = $this->renderingContext->getControllerContext()->getRequest()->getControllerExtensionName();
        $pluginName = $this->renderingContext->getControllerContext()->getRequest()->getPluginName();
        $this->widgetContext->setParentExtensionName($extensionName);
        $this->widgetContext->setParentPluginName($pluginName);
        $pluginNamespace = $this->extensionService->getPluginNamespace($extensionName, $pluginName);
        $this->widgetContext->setParentPluginNamespace($pluginNamespace);
        $this->widgetContext->setWidgetViewHelperClassName(get_class($this));
        if ($this->ajaxWidget === true) {
            $this->ajaxWidgetContextHolder->store($this->widgetContext);
        }
    }

    /**
     * Stores the syntax tree child nodes in the Widget Context, so they can be
     * rendered with <f:widget.renderChildren> lateron.
     *
     * @param array $childNodes The SyntaxTree Child nodes of this ViewHelper.
     * @return void
     */
    public function setChildNodes(array $childNodes)
    {
        $rootNode = $this->objectManager->get(RootNode::class);
        foreach ($childNodes as $childNode) {
            $rootNode->addChildNode($childNode);
        }
        $this->widgetContext->setViewHelperChildNodes($rootNode, $this->renderingContext);
    }

    /**
     * Generate the configuration for this widget. Override to adjust.
     *
     * @return array
     * @api
     */
    protected function getWidgetConfiguration()
    {
        return $this->arguments;
    }

    /**
     * Initiate a sub request to $this->controller. Make sure to fill $this->controller
     * via Dependency Injection.
     *
     * @return \TYPO3\CMS\Extbase\Mvc\ResponseInterface the response of this request.
     * @throws \TYPO3\CMS\Fluid\Core\Widget\Exception\MissingControllerException
     * @api
     */
    protected function initiateSubRequest()
    {
        if (!$this->controller instanceof AbstractWidgetController) {
            if (isset($this->controller)) {
                throw new MissingControllerException('initiateSubRequest() can not be called if there is no valid controller extending TYPO3\\CMS\\Fluid\\Core\\Widget\\AbstractWidgetController. Got "' . get_class($this->controller) . '" in class "' . get_class($this) . '".',
                    1289422564);
            }
            throw new MissingControllerException('initiateSubRequest() can not be called if there is no controller inside $this->controller. Make sure to add a corresponding injectController method to your WidgetViewHelper class "' . get_class($this) . '".',
                1284401632);
        }
        $subRequest = $this->objectManager->get(WidgetRequest::class);
        $subRequest->setWidgetContext($this->widgetContext);
        $this->passArgumentsToSubRequest($subRequest);
        $subResponse = $this->objectManager->get(Response::class);
        $this->controller->processRequest($subRequest, $subResponse);
        return $subResponse;
    }

    /**
     * Pass the arguments of the widget to the subrequest.
     *
     * @param \TYPO3\CMS\Fluid\Core\Widget\WidgetRequest $subRequest
     * @return void
     */
    private function passArgumentsToSubRequest(WidgetRequest $subRequest)
    {
        $arguments = $this->renderingContext->getControllerContext()->getRequest()->getArguments();
        $widgetIdentifier = $this->widgetContext->getWidgetIdentifier();
        if (isset($arguments[$widgetIdentifier])) {
            if (isset($arguments[$widgetIdentifier]['action'])) {
                $subRequest->setControllerActionName($arguments[$widgetIdentifier]['action']);
                unset($arguments[$widgetIdentifier]['action']);
            }
            $subRequest->setArguments($arguments[$widgetIdentifier]);
        }
    }

    /**
     * The widget identifier is unique on the current page, and is used
     * in the URI as a namespace for the widget's arguments.
     *
     * @return string the widget identifier for this widget
     * @return void
     * @throws \TYPO3Fluid\Fluid\Core\Exception
     * @todo clean up, and make it somehow more routing compatible.
     */
    private function initializeWidgetIdentifier()
    {
        if ($this->hasArgument('widgetId')) {
            $widgetIdentifier = '@widget_' . $this->arguments['widgetId'];
        } else {
            if (!$this->viewHelperVariableContainer->exists(\TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper::class,
                'nextWidgetNumber')
            ) {
                $widgetCounter = 0;
            } else {
                $widgetCounter = $this->viewHelperVariableContainer->get(\TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper::class,
                    'nextWidgetNumber');
            }
            $widgetIdentifier = '@widget_' . $widgetCounter;
            $this->viewHelperVariableContainer->addOrUpdate(\TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper::class,
                'nextWidgetNumber', $widgetCounter + 1);
        }
        $this->widgetContext->setWidgetIdentifier($widgetIdentifier);
    }

    /**
     * @param string $argumentsName
     * @param string $closureName
     * @param string $initializationPhpCode
     * @param \TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode $node
     * @param \TYPO3Fluid\Fluid\Core\Compiler\TemplateCompiler $compiler
     */
    public function compile($argumentsName, $closureName, &$initializationPhpCode, ViewHelperNode $node, TemplateCompiler $compiler)
    {
        $compiler->disable();
        return '\'\'';
    }

    public function injectExtensionService(ExtensionService $extensionService): void
    {
        $this->extensionService = $extensionService;
    }
}
