<?php

namespace Albert221\Blog\Repository\Database;

use Albert221\Blog\Repository\TagRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository implements TagRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function paginated(Criteria $criteria)
    {
        $query = $this->createQueryBuilder('t')
            ->addCriteria($criteria)
            ->getQuery();

        return $query->getResult();
    }
}
