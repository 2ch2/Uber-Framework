<?php

namespace app\Model\User;

/**
 * Model for account ranks.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 * @Entity
 * @Table(name="ranks")
 */
class RankModel
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
     * @Column(type="string", length=32, unique=true)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $permissions;
}