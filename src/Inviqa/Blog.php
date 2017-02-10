<?php

namespace Inviqa;

use Contentful\Delivery\Client;
use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceArray;
use Contentful\ResourceNotFoundException;

class Blog
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
     * @return ResourceArray
     */
    public function getBlogPosts()
    {
        $query = $this->queryFactory->createQuery($this->postContentTypeId);
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
