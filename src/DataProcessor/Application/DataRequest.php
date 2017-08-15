<?php

namespace Mpwar\DataProcessor\Application;

class DataRequest
{
    /**
     * @var string
     */
    private $sourceId;
    /**
     * @var string
     */
    private $keyword;
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var string
     */
    private $author;
    /**
     * @var string
     */
    private $authorLocation;
    /**
     * @var string
     */
    private $language;

    public function __construct(
        string $sourceId,
        string $keyword,
        string $source,
        string $content,
        string $createdAt,
        string $author,
        string $authorLocation,
        string $language
    ) {

        $this->sourceId       = $sourceId;
        $this->keyword        = $keyword;
        $this->source         = $source;
        $this->content        = $content;
        $this->createdAt      = $createdAt;
        $this->author         = $author;
        $this->authorLocation = $authorLocation;
        $this->language       = $language;
    }

    /**
     * @return string
     */
    public function sourceId(): string
    {
        return $this->sourceId;
    }

    /**
     * @return string
     */
    public function keyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function createdAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function author(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function authorLocation(): string
    {
        return $this->authorLocation;
    }

    /**
     * @return string
     */
    public function language(): string
    {
        return $this->language;
    }
}
