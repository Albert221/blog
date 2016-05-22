<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Tag;

interface TagRepositoryInterface
{
    /**
     * @param int $page
     * @param int $perPage
     * @return Tag[]
     */
    public function paginated($page, $perPage);
}
