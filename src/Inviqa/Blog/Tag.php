<?php

namespace Inviqa\Blog;

use Contentful\Delivery\Client;
use Contentful\ResourceNotFoundException;

class Tag
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

    public function getSingleTagByName($name)
    {
        $query = $this->queryFactory->createQuery($this->postContentTypeId);
        $query
            ->where('fields.name', $name)
            ->setLimit(1);

        $tags = $this->client->getEntries($query);

        if ($tags->getTotal() !== 1) {
            throw new ResourceNotFoundException();
        }

        return $tags->offsetGet(0);
    }
}