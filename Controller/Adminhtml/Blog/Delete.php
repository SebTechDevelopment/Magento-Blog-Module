<?php

namespace SebTech\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPostRepository;

class Delete extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    private BlogPostRepository $blogPostRepository;

    public function __construct(Context $context, BlogPostRepository $blogPostRepository)
    {
        parent::__construct($context);
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'SebTech_Blog::blog_delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $title = "";
            try {
                // init model and delete
                /** @var BlogPost $blogpost */
                $blogpost = $this->blogPostRepository->getById($id);

                // extract title for display
                $title = $blogpost->getTitle();

                // Delete the post
                $this->blogPostRepository->deleteById($id);

                // display success message
                $this->messageManager->addSuccessMessage(__('The Blog Post has been deleted.'));

                // go to grid
                $this->_eventManager->dispatch('adminhtml_blogpost_on_delete', [
                    'title' => $title,
                    'status' => 'success'
                ]);

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_blogpost_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('Unable to delete this post.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
