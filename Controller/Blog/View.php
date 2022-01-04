<?php

namespace SebTech\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use SebTech\Blog\Helper\Blog as BlogHelper;


class View extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    private RequestInterface $request;
    private ForwardFactory $resultForwardFactory;
    private BlogHelper $blogHelper;

    public function __construct(
        Context $context,
        RequestInterface $request,
        BlogHelper $blogHelper,
        ForwardFactory $resultForwardFactory
    ){
        parent::__construct($context);
        $this->request = $request;
        $this->blogHelper = $blogHelper;
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->blogHelper->prepareResultBlog($this, $this->getPageId());
        if (!$resultPage) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $resultPage;
    }

    /**
     * Returns Blog ID if provided or null
     *
     * @return int|null
     */
    private function getPageId(): ?int
    {
        $id = $this->request->getParam('id');
        return $id ? (int)$id : null;
    }
}
