<?php

namespace SebTech\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPostFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use SebTech\Blog\Model\BlogPostRepository;
use Magento\Framework\App\Request\DataPersistorInterface;

class Save extends Action implements HttpPostActionInterface
{
    private BlogPostFactory $blogPostFactory;
    private BlogPostRepository $blogPostRepository;
    private DataPersistorInterface $dataPersistor;

    public function __construct(
        Context                $context,
        BlogPostFactory        $blogPostFactory,
        BlogPostRepository     $blogPostRepository,
        DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
        $this->blogPostFactory = $blogPostFactory;
        $this->blogPostRepository = $blogPostRepository;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * @return Redirect|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->blogPostFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->blogPostRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Blog post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->blogPostRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the blog post.'));
                $this->dataPersistor->clear('sebtech_blog');
                return $this->processBlogReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the blog.'));
            }
            $this->dataPersistor->set('sebtech_blog', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param BlogPost $model
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    private function processBlogReturn(BlogPost $model, array $data, ResultInterface $resultRedirect): ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
