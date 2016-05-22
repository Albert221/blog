<?php

namespace Albert221\Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="\Albert221\Blog\Repository\DatabaseCategoryRepository") @Table(name="categories")
 */
class Category
{
    /**
     * @var int Id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string Name
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string Slug
     * @Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @var ArrayCollection Posts
     * @OneToMany(targetEntity="Post", mappedBy="category")
     */
    protected $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}
