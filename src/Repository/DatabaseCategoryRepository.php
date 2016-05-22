<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Post;
use Doctrine\ORM\EntityRepository;

class DatabaseCategoryRepository extends EntityRepository implements CategoryRepositoryInterface
{
    public function count()
    {
        $query = $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function paginated($page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $query = $this->createQueryBuilder('c')
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }

    public function postsCount($slug)
    {
        $qb = $this->createQueryBuilder('c');

        $query = $qb->select('count(p.id)')
            ->join('c.posts', 'p')
            ->where($qb->expr()->eq('c.slug', ':slug'))
            ->setParameter(':slug', $slug)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function postsPaginated($slug, $page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb->select('p')
            ->from(Post::class, 'p')
            ->join('p.category', 'c')
            ->where($qb->expr()->eq('c.slug', ':slug'))
            ->setParameter(':slug', $slug)
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }
}
