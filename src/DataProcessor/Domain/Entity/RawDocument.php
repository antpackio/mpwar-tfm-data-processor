<?php

namespace Mpwar\DataProcessor\Domain\Entity;

use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentContent;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentId;
use Mpwar\DataProcessor\Domain\ValueObject\RawDocumentSource;

class RawDocument
{
    private $id;
    private $source;
    private $content;

    public function __construct(RawDocumentId $id, RawDocumentSource $source, RawDocumentContent $content)
    {
        $this->id = $id;
        $this->source = $source;
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

    public function content() :RawDocumentContent
    {
        return $this->content;
    }
}
