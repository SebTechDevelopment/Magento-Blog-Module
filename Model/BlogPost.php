<?php

namespace SebTech\Blog\Model;

use DateTime;
use Exception;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use SebTech\Blog\Api\Data\BlogPostInterface;

class BlogPost  extends AbstractModel implements BlogPostInterface, IdentityInterface
{
    const CACHE_TAG = 'blogpost_d';

    /**
     * Possible Blog Status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\SebTech\Blog\Model\ResourceModel\BlogPost::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->getData('title');
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->setData('title', $title);
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return (string) $this->getData('author');
    }

    /**
     * @param string $author
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->setData('author', $author);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return (string) $this->getData('content');
    }

    /**
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->setData('content', $content);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->getData('created_at'));
    }

    /**
     * @param DateTime $dateTime
     * @return void
     */
    public function setCreatedAt(DateTime $dateTime): void
    {
        $this->setData('created_at', $dateTime);
    }

    /**
     * @param bool $enabled
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->setData('enabled', $enabled);
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->getData('enabled');
    }

    /**
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

}
