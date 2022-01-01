<?php

namespace SebTech\Blog\Model\BlogPost;

use Magento\Cms\Model\Block;
use Magento\Framework\Data\OptionSourceInterface;
use SebTech\Blog\Model\BlogPost;

class IsActive implements OptionSourceInterface
{
    private BlogPost $blogPost;

    /**
     * @param BlogPost $blogPost
     */
    public function __construct(BlogPost $blogPost)
    {
        $this->blogPost = $blogPost;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $availableOptions = $this->blogPost->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
