<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Post;
use Doctrine\Common\Collections\Criteria;

interface PostRepositoryInterface
{
    /**
     * @return int
     */
    public function count();

    /**
     * @param Criteria $criteria
     * @return Post[]
     */
    public function paginated(Criteria $criteria);

    /**
     * @param string $slug
     * @return Post
     */
    public function bySlug($slug);

    /**
     * @param string $slug
     * @return int
     */
    public function byCategoryCount($slug);

    /**
     * @param string $slug
     * @param Criteria $criteria
     * @return Post[]
     */
    public function byCategory($slug, Criteria $criteria);

    /**
     * @param string $slug
     * @return int
     */
    public function byTagCount($slug);

    /**
     * @param string $slug
     * @param Criteria $criteria
     * @return Post[]
     */
    public function byTag($slug, Criteria $criteria);

    /**
     * @param string $term
     * @return int
     */
    public function searchCount($term);

    /**
     * Searches for term in title and content respectively.
     *
     * @param string $term
     * @param Criteria $criteria
     * @return Post[]
     */
    public function search($term, Criteria $criteria);

    /**
     * @param Post $post
     */
    public function save(Post $post);
}
