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
     * @param string $category
     * @param int $page
     * @param int $perPage
     * @return Post[]
     */
    public function byCategory($category, $page, $perPage);
}
