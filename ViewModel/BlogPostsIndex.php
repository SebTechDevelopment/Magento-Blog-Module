<?php

namespace SebTech\Blog\ViewModel;

use Exception;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Cms\Model\Template\FilterProvider;
use SebTech\Blog\Model\ResourceModel\BlogPost\Collection as BlogPostCollection;

class BlogPostsIndex implements ArgumentInterface
{
    /**
     * @var BlogPostCollection
     */
    private BlogPostCollection $blogPostCollection;
    private FilterProvider $filterProvider;

    /**
     * @param BlogPostCollection $blogPostCollection
     * @param FilterProvider $filterProvider
     */
    public function __construct(BlogPostCollection $blogPostCollection, FilterProvider $filterProvider)
    {
        $this->blogPostCollection = $blogPostCollection;
        $this->filterProvider = $filterProvider;
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

    /**
     * @param string $content
     * @return string
     * @throws Exception
     */
    public function filterContentForFrontend(string $content): string
    {
        return $this->filterProvider->getPageFilter()->filter($content);
    }


}
