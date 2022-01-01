<?php

namespace SebTech\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BlogPost extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sebtech_blog_post', 'id');
    }
}
