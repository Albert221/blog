<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return int
     */
    public function count();

    /**
     * @param int $page
     * @param int $perPage
     * @return Category[]
     */
    public function paginated($page, $perPage);

    /**
     * @param int $count
     * @return Category[]
     */
    public function lastCategories($count);
}
