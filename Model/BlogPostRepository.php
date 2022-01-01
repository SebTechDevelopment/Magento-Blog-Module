<?php

namespace SebTech\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use SebTech\Blog\Api\Data\BlogPostSearchResultsInterface;
use SebTech\Blog\Api\Data\BlogPostSearchResultsInterfaceFactory as SearchResultsFactory;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPostFactory;
use SebTech\Blog\Model\ResourceModel\BlogPost as BlogPostResource;
use SebTech\Blog\Model\ResourceModel\BlogPost\Collection as BlogPostCollection;
use SebTech\Blog\Model\ResourceModel\BlogPost\CollectionFactory as BlogPostCollectionFactory;


class BlogPostRepository
{
    private $resource;

    private $detailsFactory;

    private $collectionFactory;

    private $searchResultsFactory;

    private $collectionProcessor;

    public function __construct(
        BlogPostResource $resource,
        BlogPostFactory $detailsFactory,
        BlogPostCollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->detailsFactory = $detailsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(BlogPost $blogpost)
    {
        try {
            $this->resource->save($blogpost);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $blogpost;
    }

    public function getById($detailsId)
    {
        $details = $this->detailsFactory->create();
        $this->resource->load($details, $detailsId);

        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The order details associated with the "%1" ID doesn\'t exist.', $detailsId));
        }
        return $details;
    }

    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var BlogPostCollection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var BlogPostSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(BlogPost $blogPost)
    {
        try {
            $this->resource->delete($blogPost);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    public function deleteById($blockId)
    {
        return $this->delete($this->getById($blockId));
    }
}
