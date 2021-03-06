<?php

namespace Albert221\Blog\Repository\Database;

use Albert221\Blog\Repository\CategoryRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{
    public function count()
    {
        $query = $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function paginated(Criteria $criteria)
    {
        $query = $this->createQueryBuilder('c')
            ->addCriteria($criteria)
            ->getQuery();

        return $query->getResult();
    }

    public function last($count)
    {
        $query = $this->createQueryBuilder('c')
            ->join('c.posts', 'p')
            ->orderBy('p.published_at', 'DESC')
            ->setMaxResults($count)
            ->getQuery();
        
        return $query->getResult();
    }
}
