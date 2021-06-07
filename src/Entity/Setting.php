<?php

namespace App\Entity;

use App\Repository\SettingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SettingRepository::class)
 */
class Setting
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $appName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $smtpUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $smtpPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $smtpHost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $smtpPort;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="settings")
     */
    private $userRole;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArticlePublish;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLoginUserAuthor;

    /**
     * @ORM\Column(type="integer", options={"default":"0"})
     */
    private $pageSize;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function setAppName(string $appName): self
    {
        $this->appName = $appName;

        return $this;
    }

    public function getSmtpUser(): ?string
    {
        return $this->smtpUser;
    }

    public function setSmtpUser(?string $smtpUser): self
    {
        $this->smtpUser = $smtpUser;

        return $this;
    }

    public function getSmtpPassword(): ?string
    {
        return $this->smtpPassword;
    }

    public function setSmtpPassword(?string $smtpPassword): self
    {
        $this->smtpPassword = $smtpPassword;

        return $this;
    }

    public function getSmtpHost(): ?string
    {
        return $this->smtpHost;
    }

    public function setSmtpHost(?string $smtpHost): self
    {
        $this->smtpHost = $smtpHost;

        return $this;
    }

    public function getSmtpPort(): ?string
    {
        return $this->smtpPort;
    }

    public function setSmtpPort(?string $smtpPort): self
    {
        $this->smtpPort = $smtpPort;

        return $this;
    }

    public function getUserRole(): ?Role
    {
        return $this->userRole;
    }

    public function setUserRole(?Role $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    public function getIsArticlePublish(): ?bool
    {
        return $this->isArticlePublish;
    }

    public function setIsArticlePublish(bool $isArticlePublish): self
    {
        $this->isArticlePublish = $isArticlePublish;

        return $this;
    }

    public function getIsLoginUserAuthor(): ?bool
    {
        return $this->isLoginUserAuthor;
    }

    public function setIsLoginUserAuthor(bool $isLoginUserAuthor): self
    {
        $this->isLoginUserAuthor = $isLoginUserAuthor;

        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }
}
