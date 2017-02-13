<?php

namespace spec\Inviqa\Blog;

use Contentful\Delivery\DynamicEntry;
use Contentful\ResourceNotFoundException;
use Contentful\Delivery\Query;
use Contentful\Delivery\Client;
use Contentful\ResourceArray;
use Inviqa\Blog\Post;
use Inviqa\Blog\QueryFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior
{
    private $contentTypeId = "2wlaskgda5";

    function let(Client $client, QueryFactory $queryFactory)
    {
        $this->beConstructedWith($client, $queryFactory, $this->contentTypeId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Post::class);
    }

    function it_gets_blog_posts(Client $client, QueryFactory $queryFactory)
    {
        $query = new Query();
        $queryFactory->createQuery($this->contentTypeId)->willReturn($query);

        $client->getEntries($query)->shouldBeCalled();
        $this->getBlogPosts();
    }

    function it_errors_when_not_finding_blog_post(
        Client $client,
        QueryFactory $queryFactory,
        ResourceArray $resourceArray
    ) {
        $slug = "this-is-a-blog-post";
        $query = new Query();
        $queryFactory->createQuery($this->contentTypeId)->willReturn($query);

        $client->getEntries($query)->shouldBeCalled()->willReturn($resourceArray);
        $resourceArray->getTotal()->WillReturn(0);

        $this->shouldThrow(ResourceNotFoundException::class)->duringGetSingleBlogPost($slug);
    }

    function it_gets_a_single_blog_post(
        Client $client,
        QueryFactory $queryFactory,
        ResourceArray $resourceArray,
        DynamicEntry $dynamicEntry
    ) {
        $slug = "this-is-a-blog-post";
        $query = new Query();
        $queryFactory->createQuery($this->contentTypeId)->willReturn($query);

        $client->getEntries($query)->shouldBeCalled()->willReturn($resourceArray);
        $resourceArray->getTotal()->WillReturn(1);

        $resourceArray->offsetGet(0)->willReturn($dynamicEntry);
        $this->getSingleBlogPost($slug)->shouldEqual($dynamicEntry);
    }
}
