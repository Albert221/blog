<?php

namespace Albert221\Blog\Repository\Database;

use Albert221\Blog\Entity\Post;
use Albert221\Blog\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $query = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function paginated($page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $query = $this->createQueryBuilder('p')
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function bySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function byCategoryCount($slug)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('count(p.id)')
            ->join('p.category', 'c')
            ->where($qb->expr()->eq('c.slug', ':category'))
            ->setParameter(':category', $slug)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function byCategory($slug, $page, $perPage)
    {
        $first = ($page - 1) * $perPage;
        
        $qb = $this->createQueryBuilder('p');

        $query = $qb->join('p.category', 'c')
            ->where($qb->expr()->eq('c.slug', ':category'))
            ->setParameter(':category', $slug)
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }

    public function byTagCount($slug)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('count(p.id)')
            ->join('p.tags', 't')
            ->where($qb->expr()->eq('t.slug', ':tag'))
            ->setParameter(':tag', $slug)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function byTag($slug, $page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $qb = $this->createQueryBuilder('p');

        $query = $qb->join('p.tags', 't')
            ->where($qb->expr()->eq('t.slug', ':tag'))
            ->setParameter(':tag', $slug)
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
        
    }

    /**
     * {@inheritdoc}
     */
    public function save(Post $post)
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }
}
