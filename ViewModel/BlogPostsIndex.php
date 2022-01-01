<?php

namespace SebTech\Blog\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPostRepository;
use SebTech\Blog\Model\ResourceModel\BlogPost\Collection as BlogPostCollection;

class BlogPostsIndex implements ArgumentInterface
{
    private BlogPostRepository $blogPostRepository;
    private BlogPostCollection $blogPostCollection;

    public function __construct(BlogPostRepository $blogPostRepository, BlogPostCollection $blogPostCollection)
    {
        $this->blogPostRepository = $blogPostRepository;
        $this->blogPostCollection = $blogPostCollection;
    }

    public function sayHello(): string
    {
        return "Hello from ViewModel :-)";
    }

    public function amountOfBlogsAvailable(): int
    {
        return $this->blogPostCollection->count();
    }

    public function getAllBlogs(): array
    {
        $blogs = $this->blogPostCollection->getItems();

        return $blogs;
    }

}
