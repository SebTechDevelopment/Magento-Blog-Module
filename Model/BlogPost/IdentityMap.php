<?php

namespace SebTech\Blog\Model\BlogPost;

use InvalidArgumentException;
use SebTech\Blog\Model\BlogPost;

class IdentityMap
{
    /**
     * @var BlogPost[]
     */
    private array $blogPosts = [];

    /**
     * Add a page to the list.
     *
     * @param BlogPost $blogPost
     * @return void
     * @throws InvalidArgumentException When page doesn't have an ID.
     */
    public function add(BlogPost $blogPost): void
    {
        if (!$blogPost->getId()) {
            throw new InvalidArgumentException('Cannot add non-persisted page to identity map');
        }
        $this->blogPosts[$blogPost->getId()] = $blogPost;
    }

    /**
     * Find a loaded page by ID.
     *
     * @param int $id
     * @return BlogPost|null
     */
    public function get(int $id): ?BlogPost
    {
        if (array_key_exists($id, $this->blogPosts)) {
            return $this->blogPosts[$id];
        }

        return null;
    }

    /**
     * Remove the page from the list.
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        unset($this->blogPosts[$id]);
    }

    /**
     * Clear the list.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->blogPosts = [];
    }
}
