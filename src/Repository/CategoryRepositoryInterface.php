<?php

namespace Albert221\Blog\Repository;

interface CategoryRepositoryInterface
{
    public function count();
    
    public function paginated($page, $perPage);
    
    public function postsCount($slug);

    public function postsPaginated($slug, $page, $perPage);
}
