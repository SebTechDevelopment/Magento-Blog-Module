<?php

namespace SebTech\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogPostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get posts list.
     *
     * @return \SebTech\Blog\Api\Data\BlogPostInterface[]
     */
    public function getItems();

    /**
     * Set details list.
     *
     * @param [] $items
     * @return $this
     */
    public function setItems(array $items);
}
