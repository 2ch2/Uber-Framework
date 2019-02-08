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
     * @Column(type="string", length=32, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string", length=32)
     */
    protected $password;

    /**
     * @var int
     * @OneToOne(targetEntity="RankModel")
     * @JoinColumn(referencedColumnName="id")
     */
    protected $rank;

    /**
     * @var string
     * @Column(type="datetime")
     */
    protected $joined;

    /**
     * @var string
     * @Column(type="datetime")
     */
    protected $recent_activity;

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
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank)
    {
        $this->rank = $rank;
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

    /**
     * @return string
     */
    public function getRecentActivity(): string
    {
        return $this->recent_activity;
    }

    /**
     * @throws \Exception
     */
    public function setRecentActivity()
    {
        $recent_activity = new \DateTime();
        $this->recent_activity = $recent_activity;
    }

}