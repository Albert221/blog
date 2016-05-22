<?php

namespace Albert221\Blog\Entity;

use DateTime;

/**
 * @Entity(repositoryClass="\Albert221\Blog\Repository\DatabasePostRepository") @Table(name="posts")
 */
class Post
{
    /**
     * @var int Id
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string Title
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var string Slug
     * @Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @var string Content
     * @Column(type="text")
     */
    protected $content;

    /**
     * @var DateTime Published at
     * @Column(type="datetime")
     */
    protected $published_at;

    /**
     * @var Category Category
     * @ManyToOne(targetEntity="Category", inversedBy="posts")
     */
    protected $category;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getShortContent()
    {
        return mb_substr($this->content, 0, mb_strpos($this->content, '<!--more-->'));
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getPublishedAt()
    {
        return $this->published_at;
    }

    public function setPublishedAt(DateTime $published_at)
    {
        $this->published_at = $published_at;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}