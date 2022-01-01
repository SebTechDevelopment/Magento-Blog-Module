<?php

namespace SebTech\Blog\Api\Data;

interface BlogPostInterface
{
    public function getId();

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function getAuthor(): string;

    public function setAuthor(string $author): void;

    public function getContent(): string;

    public function setContent(string $content): void;

    public function getCreatedAt(): \DateTime;

    public function setCreatedAt(\DateTime $dateTime): void;
}
