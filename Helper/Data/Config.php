<?php

namespace SebTech\Blog\Helper\Data;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getPageNotFoundPageId(): int
    {
        return $this->scopeConfig->getValue(Page::XML_PATH_NO_ROUTE_PAGE);
    }

    public function shouldBlogsRender(): bool
    {
        return $this->scopeConfig->getValue('blog/settings/enabled');
    }
}
