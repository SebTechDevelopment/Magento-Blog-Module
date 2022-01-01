<?php

namespace SebTech\Blog\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use SebTech\Blog\Model\ResourceModel\BlogPost\Collection as BlogPostCollection;

class BlogPostsIndex implements ArgumentInterface
{
    /**
     * @var BlogPostCollection
     */
    private BlogPostCollection $blogPostCollection;

    /**
     * @param BlogPostCollection $blogPostCollection
     */
    public function __construct(BlogPostCollection $blogPostCollection)
    {
        $this->blogPostCollection = $blogPostCollection;
    }

    /**
     * @return string
     */
    public function sayHello(): string
    {
        return "Hello from ViewModel :-)";
    }

    /**
     * @return int
     */
    public function amountOfBlogsAvailable(): int
    {
        return $this->blogPostCollection->count();
    }

    /**
     * @return array
     */
    public function getAllBlogs(): array
    {
        return $this->blogPostCollection->getItems();
    }

}
