<?php

namespace SebTech\Blog\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use SebTech\Blog\Api\Data\BlogPostSearchResultsInterface;
use SebTech\Blog\Api\Data\BlogPostSearchResultsInterfaceFactory as SearchResultsFactory;
use SebTech\Blog\Model\ResourceModel\BlogPost as BlogPostResource;
use SebTech\Blog\Model\ResourceModel\BlogPost\CollectionFactory as BlogPostCollectionFactory;

class BlogPostRepository
{
    /**
     * @var BlogPostResource
     */
    private BlogPostResource $resource;

    /**
     * @var BlogPostFactory
     */
    private BlogPostFactory $blogPostFactory;

    /**
     * @var BlogPostCollectionFactory
     */
    private BlogPostCollectionFactory $collectionFactory;

    /**
     * @var SearchResultsFactory
     */
    private SearchResultsFactory $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        BlogPostResource $resource,
        BlogPostFactory $detailsFactory,
        BlogPostCollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->blogPostFactory = $detailsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param BlogPost $blogpost
     * @return BlogPost
     * @throws CouldNotSaveException
     */
    public function save(BlogPost $blogpost): BlogPost
    {
        try {
            $this->resource->save($blogpost);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blogpost;
    }

    /**
     * @param int $blogId
     * @return BlogPost
     * @throws NoSuchEntityException
     */
    public function getById(int $blogId): BlogPost
    {
        $details = $this->blogPostFactory->create();
        $this->resource->load($details, $blogId);

        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The blog ID "%1" doesn\'t exist.', $blogId));
        }
        return $details;
    }

    /**
     * @param SearchCriteriaInterface $criteria
     * @return BlogPostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): BlogPostSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param BlogPost $blogPost
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BlogPost $blogPost): bool
    {
        try {
            $this->resource->delete($blogPost);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $blockId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $blockId): bool
    {
        return $this->delete($this->getById($blockId));
    }
}
