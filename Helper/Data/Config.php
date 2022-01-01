<?php

namespace SebTech\Blog\Helper\Data;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const BLOG_SETTINGS_ENABLED = 'blog/settings/enabled';
    const BLOG_SETTINGS_LINK_IN_MENU = 'blog/settings/link_in_menu';

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
        return $this->scopeConfig->isSetFlag(self::BLOG_SETTINGS_ENABLED);
    }

    public function shouldLinkBeInMenu(): bool
    {
        return $this->scopeConfig->isSetFlag(self::BLOG_SETTINGS_LINK_IN_MENU);
    }
}
