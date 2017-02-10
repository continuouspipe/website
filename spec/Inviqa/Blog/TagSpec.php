<?php

namespace spec\Inviqa\Blog;

use Contentful\Delivery\Client;
use Contentful\Delivery\DynamicEntry;
use Contentful\Delivery\Query;
use Contentful\ResourceArray;
use Inviqa\Blog\QueryFactory;
use Inviqa\Blog\Tag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagSpec extends ObjectBehavior
{
    private $contentTypeId = "tag";

    function let(Client $client, QueryFactory $queryFactory)
    {
        $this->beConstructedWith($client, $queryFactory, $this->contentTypeId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_gets_a_single_blog_post(
        Client $client,
        QueryFactory $queryFactory,
        ResourceArray $resourceArray,
        DynamicEntry $dynamicEntry
    ) {
        $tagName = "PHP";
        $query = new Query();
        $queryFactory->createQuery($this->contentTypeId)->willReturn($query);

        $client->getEntries($query)->shouldBeCalled()->willReturn($resourceArray);
        $resourceArray->getTotal()->WillReturn(1);

        $resourceArray->offsetGet(0)->willReturn($dynamicEntry);
        $this->getSingleTagByName($tagName)->shouldEqual($dynamicEntry);
    }
}
