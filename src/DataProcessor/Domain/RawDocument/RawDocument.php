<?php

namespace Mpwar\DataProcessor\Domain\RawDocument;

class RawDocument
{
    private $id;
    private $source;
    private $keyword;
    private $content;

    public function __construct(
        RawDocumentId $id,
        RawDocumentSource $source,
        RawDocumentKeyword $keyword,
        RawDocumentContent $content
    ) {
        $this->id = $id;
        $this->source = $source;
        $this->keyword = $keyword;
        $this->content = $content;
    }

    public function source(): RawDocumentSource
    {
        return $this->source;
    }

    public function id(): RawDocumentId
    {
        return $this->id;
    }

    public function content(): RawDocumentContent
    {
        return $this->content;
    }

    public function keyword(): RawDocumentKeyword
    {
        return $this->keyword;
    }
}
