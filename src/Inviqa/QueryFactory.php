<?php

namespace Inviqa;

use Contentful\Delivery\Query;

class QueryFactory
{

    /**
     * @param string $contentType
     *
     * @return Query
     */
    public function createQuery($contentType)
    {
        $query = new Query();
        $query->setContentType($contentType);
        return $query;
    }
}