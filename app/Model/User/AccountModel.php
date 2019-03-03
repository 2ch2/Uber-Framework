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
     * @Column(type="string", length=32, unique=true)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;

    /**
     * @var int
     * @Column(type="integer")
     */
    protected $rank_id;

    /**
     * @var object
     * @Column(type="datetime")
     */
    protected $joined;

    /**
     * @var object
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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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
    public function getRankId():? int
    {
        return $this->rank_id;
    }

    /**
     * @param int $rankId
     */
    public function setRankId(int $rankId)
    {
        $this->rank_id = $rankId;
    }

    /**
     * @return object
     */
    public function getJoined(): object
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
     * @return object
     */
    public function getRecentActivity(): object
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