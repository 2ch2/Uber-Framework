<?php

namespace app\Model\User;

/**
 * Model for rank permissions.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @Entity
 * @Table(name="permissions")
 */
class PermissionModel
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
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;
}