<?php

namespace Albert221\Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="\Albert221\Blog\Repository\Database\TagRepository") @Table(name="tags")
 */
class Tag
{
    /**
     * @var int Id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string Name
     * @Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @var ArrayCollection Posts
     * @ManyToMany(targetEntity="Post", mappedBy="tags")
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

    public function getPosts()
    {
        return $this->posts;
    }
}
