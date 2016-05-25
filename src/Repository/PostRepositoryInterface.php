<?php

namespace Albert221\Blog\Repository;

use Albert221\Blog\Entity\Post;

interface PostRepositoryInterface
{
    /**
     * @return int
     */
    public function count();
    
    /**
     * @param int $page
     * @param int $perPage
     * @return Post[]
     */
    public function paginated($page, $perPage);

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
     * @param int $page
     * @param int $perPage
     * @return Post[]
     */
    public function byCategory($slug, $page, $perPage);

    /**
     * @param string $slug
     * @return int
     */
    public function byTagCount($slug);

    /**
     * @param string $slug
     * @param int $page
     * @param int $perPage
     * @return Post[]
     */
    public function byTag($slug, $page, $perPage);

    /**
     * @param string $term
     * @return int
     */
    public function searchCount($term);

    /**
     * Searches for term in title and content respectively.
     *
     * @param string $term
     * @param int $page
     * @param int $perPage
     * @return Post[]
     */
    public function search($term, $page, $perPage);

    /**
     * @param Post $post
     */
    public function save(Post $post);
}
