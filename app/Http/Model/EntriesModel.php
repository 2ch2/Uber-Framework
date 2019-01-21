<?php

namespace app\Http\Model;

/**
 * Model for entries
 *
 * Class EntriesModel
 *
 * @category Model
 *
 * @package app\Http\Model
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 *
 * @Entity
 * @Table(name="entries")
 */
class EntriesModel
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var string
     * @Column(type="text")
     */
    protected $content;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }
}