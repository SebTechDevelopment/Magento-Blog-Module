<?php

namespace SebTech\Blog\Helper;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page as ResultPage;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPost\IdentityMap;
use Magento\Framework\Registry;


class Blog extends AbstractHelper
{
    private BlogPost $blogPost;
    private PageFactory $resultPageFactory;
    private Escaper $escaper;
    private IdentityMap $identityMap;
    private Registry $registry;

    /**
     * @param Context $context
     * @param BlogPost $blogPost
     * @param PageFactory $resultPageFactory
     * @param Escaper $escaper
     * @param IdentityMap $identityMap
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        BlogPost $blogPost,
        PageFactory $resultPageFactory,
        Escaper $escaper,
        IdentityMap $identityMap,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->blogPost = $blogPost;
        $this->resultPageFactory = $resultPageFactory;
        $this->escaper = $escaper;
        $this->identityMap = $identityMap;
        $this->registry = $registry;
    }

    public function prepareResultBlog(ActionInterface $action, $blogId = null)
    {
        if ($blogId !== null && $blogId !== $this->blogPost->getId()) {
            $delimiterPosition = strrpos((string)$blogId, '|');
            if ($delimiterPosition) {
                $blogId = substr($blogId, 0, $delimiterPosition);
            }
            if (!$this->blogPost->load($blogId)) {
                return false;
            }
        }

        if (!$this->blogPost->getId()) {
            return false;
        }


        $this->registry->register('current_blog_post',$this->blogPost);
        $this->identityMap->add($this->blogPost);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->addHandle('sebtech_blogpost_view');
        $pageHandles = ['id' => str_replace('/', '_', $this->blogPost->getIdentifier())];


        $resultPage->addPageLayoutHandles($pageHandles);

        return $resultPage;
    }
}
