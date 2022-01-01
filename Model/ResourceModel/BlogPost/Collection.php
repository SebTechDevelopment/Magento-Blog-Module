<?php

namespace SebTech\Blog\Model\ResourceModel\BlogPost;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SebTech\Blog\Model\BlogPost as BlogPostModel;
use SebTech\Blog\Model\ResourceModel\BlogPost as BlogPostResourceModel;


class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BlogPostModel::class, BlogPostResourceModel::class);
    }
}
