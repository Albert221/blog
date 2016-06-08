<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Category;
use Doctrine\Common\Collections\Criteria;

interface CategoryRepositoryInterface
{
    /**
     * @return int
     */
    public function count();

    /**
     * @param Criteria $criteria
     * @return Category[]
     */
    public function paginated(Criteria $criteria);

    /**
     * @param int $count
     * @return Category[]
     */
    public function last($count);
}
