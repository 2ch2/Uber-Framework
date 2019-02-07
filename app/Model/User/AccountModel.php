<?php

namespace app\Model\User;

/**
 * Model for registered accounts.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @Entity
 * @Table(name="accounts")
 */
class AccountModel
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
    protected $username;

    /**
     * @var string
     * @Column(type="string", length=32, nullable=false)
     */
    protected $password;

    /**
     * @var int
     * @Column(type="string", options={"default" : 1})
     */
    protected $rankId;

    /**
     * @var string
     * @Column(type="datetime")
     */
    protected $joined;

    /**
     * @return string
     */
    public function getRecentActivity(): string
    {
        return $this->recentActivity;
    }

    /**
     * @param string $recentActivity
     */
    public function setRecentActivity(string $recentActivity): void
    {
        $this->recentActivity = $recentActivity;
    }

    /**
     * @var string
     * @Column(type="datetime")
     */
    protected $recentActivity;

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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getRankId(): int
    {
        return $this->rankId;
    }

    /**
     * @param int $rankId
     */
    public function setRankId(int $rankId)
    {
        $this->rankId = $rankId;
    }

    /**
     * @return string
     */
    public function getJoined(): string
    {
        return $this->joined;
    }

    /**
     * @throws \Exception
     */
    public function setJoined()
    {
        $joined = new \DateTime();
        $this->joined = $joined;
    }
}