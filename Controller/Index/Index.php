<?php
namespace SebTech\Blog\Controller\Index;

use Magento\Framework\App\Action\Action as Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use SebTech\Blog\Helper\Data\Config;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ResultFactory $resultFactory
     * @param Config $config
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ResultFactory $resultFactory,
        Config $config
    ) {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->resultFactory = $resultFactory;
        $this->config = $config;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        if (!$this->config->shouldBlogsRender()) {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('noroute');
        }
        return $this->_pageFactory->create();
    }
}
