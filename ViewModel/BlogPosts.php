<?php

namespace SebTech\Blog\ViewModel;

use Exception;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Cms\Model\Template\FilterProvider;
use SebTech\Blog\Model\BlogPost;
use SebTech\Blog\Model\BlogPostRepository;
use SebTech\Blog\Model\ResourceModel\BlogPost\Collection as BlogPostCollection;

class BlogPosts implements ArgumentInterface
{
    private BlogPostCollection $blogPostCollection;
    private FilterProvider $filterProvider;
    private BlogPostRepository $blogPostRepository;
    private Registry $registry;
    private UrlInterface $urlBuilder;

    /**
     * @param BlogPostCollection $blogPostCollection
     * @param FilterProvider $filterProvider
     * @param BlogPostRepository $blogPostRepository
     * @param Registry $registry
     */
    public function __construct(
        BlogPostCollection $blogPostCollection,
        FilterProvider $filterProvider,
        BlogPostRepository $blogPostRepository,
        Registry $registry,
        UrlInterface $urlBuilder
    ) {
        $this->blogPostCollection = $blogPostCollection;
        $this->filterProvider = $filterProvider;
        $this->blogPostRepository = $blogPostRepository;
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;
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

    public function getBlogPost(): BlogPost
    {
        return $this->registry->registry('current_blog_post');
    }

    public function getBlogUrl(int $id): string
    {
        return $this->urlBuilder->getUrl('blog/blog/view',['id' => $id]);
    }

    public function getReturnUrl(): string
    {
        return $this->urlBuilder->getUrl("*/");
    }
}
