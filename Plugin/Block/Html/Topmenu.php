<?php

namespace SebTech\Blog\Plugin\Block\Html;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;
use Magento\Theme\Block\Html\Topmenu as coreTopMenu;
use SebTech\Blog\Helper\Data\Config;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected NodeFactory $nodeFactory;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param NodeFactory $nodeFactory
     * @param UrlInterface $urlBuilder
     * @param Config $config
     */
    public function __construct(NodeFactory $nodeFactory, UrlInterface $urlBuilder, Config $config)
    {
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
        $this->config = $config;
    }

    /**
     * @param coreTopMenu $subject
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return void
     */
    public function beforeGetHtml(
        coreTopMenu $subject,
        string      $outermostClass = '',
        string      $childrenWrapClass = '',
        int $limit = 0
    ) {
        if($this->config->shouldLinkBeInMenu()) {
            $menuNode = $this->nodeFactory->create(['data' => $this->getNodeAsArray("Blog", "menu_blog"),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree(),]);
            $subject->getMenu()->addChild($menuNode);
        }
    }

    /**
     * @param string $name
     * @param string $id
     * @return array
     */
    protected function getNodeAsArray(string $name, string $id): array
    {
        $url = $this->urlBuilder->getUrl("blog/index"); //here you can add url as per your choice of menu
        return ['name' => __($name),
            'id' => $id,
            'url' => $url,
            'has_active' => false,
            'is_active' => false,
        ];
    }
}
