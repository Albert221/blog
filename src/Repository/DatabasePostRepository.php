<?php

namespace Albert221\Blog\Repository;

use Doctrine\ORM\EntityRepository;

class DatabasePostRepository extends EntityRepository implements PostRepositoryInterface
{
    public function count()
    {
        $query = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }
    
    public function paginated($page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $query = $this->createQueryBuilder('p')
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }

    public function bySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function byCategory($category, $page, $perPage)
    {
        $first = ($page - 1) * $perPage;
        
        $qb = $this->createQueryBuilder('p');

        $query = $qb->join('p.category', 'c')
            ->where($qb->expr()->eq('c.slug', ':category'))
            ->setParameter(':category', $category)
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }
}
