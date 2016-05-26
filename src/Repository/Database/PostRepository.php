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
            ->orderBy('p.published_at', 'DESC')
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
            ->orderBy('p.published_at', 'DESC')
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
            ->orderBy('p.published_at', 'DESC')
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function searchCount($term)
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('MATCH (p.title, p.content) AGAINST (:term) > 1')
            ->setParameter(':term', $term)
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function search($term, $page, $perPage)
    {
        $first = ($page - 1) * $perPage;

        $query = $this->createQueryBuilder('p')
            ->select(
                'p as post',
                'MATCH (p.title) AGAINST (:term) as title_relevance',
                'MATCH (p.title, p.content) AGAINST (:term) as relevance'
            )
            ->where('MATCH (p.title, p.content) AGAINST (:term) > 1')
            ->orderBy('title_relevance', 'DESC')
            ->addOrderBy('relevance', 'DESC')
            ->setParameter(':term', $term)
            ->setFirstResult($first)
            ->setMaxResults($perPage)
            ->getQuery();

        $result = $query->getResult();

        // because we don't want an array of post and relevances, a post only
        array_walk($result, function (&$value) {
            $value = $value['post'];
        });

        return $result;
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
