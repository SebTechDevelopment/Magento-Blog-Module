<?php

namespace SebTech\Blog\Controller\Noroute;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use SebTech\Blog\Helper\Data\Config;

class Index extends Action
{
    /**
     * @var ForwardFactory
     */
    protected ForwardFactory $resultForwardFactory;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param Config $config
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        Config $config
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
        $this->config = $config;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $pageId = $this->config->getPageNotFoundPageId();

        /** @var Page $pageHelper */
        $pageHelper = $this->_objectManager->get(Page::class);
        $resultPage = $pageHelper->prepareResultPage($this, $pageId);

        if ($resultPage) {
            $resultPage->setStatusHeader(404, '1.1', 'Not Found');
            $resultPage->setHeader('Status', '404 File not found');
            return $resultPage;
        } else {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->setController('index');
            $resultForward->forward('defaultNoRoute');
            return $resultForward;
        }
    }
}
