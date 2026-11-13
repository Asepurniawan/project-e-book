<?php
declare(strict_types=1);

namespace EBook;

abstract class Media
{
    public function __construct(
        protected readonly string $id,
        protected readonly string $title,
        protected readonly string $author,
        protected readonly string $category
    ) {}

    abstract public function getTypeLabel(): string;

    public function getId(): string { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getCategory(): string { return $this->category; }
}
