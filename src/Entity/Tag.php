<?php

namespace Albert221\Blog\Entity;

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
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string Slug
     * @Column(type="string", unique=true)
     */
    protected $slug;

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
