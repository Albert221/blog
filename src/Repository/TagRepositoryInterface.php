<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Tag;
use Doctrine\Common\Collections\Criteria;

interface TagRepositoryInterface
{
    /**
     * @param Criteria $criteria
     * @return Tag[]
     */
    public function paginated(Criteria $criteria);
}
