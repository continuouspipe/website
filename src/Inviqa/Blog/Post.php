<?php

namespace Inviqa\Blog;

use Contentful\Delivery\Client;
use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceArray;
use Contentful\ResourceNotFoundException;

class Post
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var QueryFactory
     */
    private $queryFactory;

    /**
     * @var string
     */
    private $postContentTypeId;

    /**
     * @param Client $client
     * @param QueryFactory $queryFactory
     * @param string $postContentTypeId
     */
    public function __construct(Client $client, QueryFactory $queryFactory, $postContentTypeId)
    {
        $this->client = $client;
        $this->queryFactory = $queryFactory;
        $this->postContentTypeId = $postContentTypeId;
    }

    /**
     * @param DynamicEntry|null $tag
     *
     * @return ResourceArray
     */
    public function getBlogPosts(DynamicEntry $tag = null)
    {
        $query = $this->queryFactory->createQuery($this->postContentTypeId);
        if ($tag) {
            $query
                ->where('fields.tags.sys.id', $tag->getId());
        }
        return $this->client->getEntries($query);
    }

    /**
     * @param string $slug
     *
     * @return DynamicEntry
     */
    public function getSingleBlogPost($slug)
    {
        $query = $this->queryFactory->createQuery($this->postContentTypeId);
        $query
            ->where('fields.slug', $slug)
            ->setLimit(1);

        $page = $this->client->getEntries($query);

        if ($page->getTotal() !== 1) {
            throw new ResourceNotFoundException();
        }

        return $page->offsetGet(0);
    }
}
