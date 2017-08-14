<?php

namespace Mpwar\DataProcessor\Domain;

class Document
{

    protected $metadataCollection;
    /**
     * @var SourceId
     */
    protected $sourceDocumentId;
    /**
     * @var SourceKeyword
     */
    protected $sourceKeyword;
    /**
     * @var SourceName
     */
    protected $sourceName;
    /**
     * @var Content
     */
    protected $content;
    /**
     * @var CreatedAt
     */
    protected $createdAt;
    /**
     * @var Author
     */
    protected $author;
    /**
     * @var AuthorLocation
     */
    protected $authorLocation;
    /**
     * @var Language
     */
    protected $language;

    public function __construct(
        SourceId $sourceDocumentId,
        SourceKeyword $sourceKeyword,
        SourceName $sourceName,
        Content $content,
        CreatedAt $createdAt,
        Author $author,
        AuthorLocation $authorLocation,
        Language $language
    ) {

        $this->setSourceDocumentId($sourceDocumentId);
        $this->setSourceKeyword($sourceKeyword);
        $this->setSourceName($sourceName);
        $this->setContent($content);
        $this->setCreatedAt($createdAt);
        $this->setAuthor($author);
        $this->setAuthorLocation($authorLocation);
        $this->setLanguage($language);
        $this->metadataCollection = new MetadataCollection();
    }

    /**
     * @param SourceId $sourceDocumentId
     */
    protected function setSourceDocumentId(SourceId $sourceDocumentId)
    {
        $this->sourceDocumentId = $sourceDocumentId;
    }

    /**
     * @param SourceKeyword $sourceKeyword
     */
    protected function setSourceKeyword(SourceKeyword $sourceKeyword)
    {
        $this->sourceKeyword = $sourceKeyword;
    }

    /**
     * @param SourceName $sourceName
     */
    protected function setSourceName(SourceName $sourceName)
    {
        $this->sourceName = $sourceName;
    }

    /**
     * @param Content $content
     */
    protected function setContent(Content $content)
    {
        $this->content = $content;
    }

    /**
     * @param CreatedAt $createdAt
     */
    protected function setCreatedAt(CreatedAt $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param Author $author
     */
    protected function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @param AuthorLocation $authorLocation
     */
    protected function setAuthorLocation(AuthorLocation $authorLocation)
    {
        $this->authorLocation = $authorLocation;
    }

    /**
     * @param Language $language
     */
    protected function setLanguage(Language $language)
    {
        $this->language = $language;
    }

    /**
     * @return SourceId
     */
    public function sourceDocumentId(): SourceId
    {
        return $this->sourceDocumentId;
    }

    /**
     * @return SourceKeyword
     */
    public function sourceKeyword(): SourceKeyword
    {
        return $this->sourceKeyword;
    }

    /**
     * @return SourceName
     */
    public function sourceName(): SourceName
    {
        return $this->sourceName;
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return $this->content;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return Author
     */
    public function author(): Author
    {
        return $this->author;
    }

    /**
     * @return AuthorLocation
     */
    public function authorLocation(): AuthorLocation
    {
        return $this->authorLocation;
    }

    /**
     * @return Language
     */
    public function language(): Language
    {
        return $this->language;
    }

    /**
     * @return MetadataCollection
     */
    public function metadataCollection(): MetadataCollection
    {
        return $this->metadataCollection;
    }

}
