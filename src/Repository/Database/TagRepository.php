<?php

namespace Albert221\Blog\Repository\Database;

use Albert221\Blog\Repository\TagRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository implements TagRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function paginated($page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $query = $this->createQueryBuilder('t')
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }
}
