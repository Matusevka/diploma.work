<?php

namespace App\Entity;

use App\Repository\WorklogsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorklogsRepository::class)
 */
class Worklogs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $github_login;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $repositorie_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sha;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $committer_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $committer_email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $html_url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments_url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_commit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGithubLogin(): ?string
    {
        return $this->github_login;
    }

    public function setGithubLogin(?string $github_login): self
    {
        $this->github_login = $github_login;

        return $this;
    }

    public function getRepositorieName(): ?string
    {
        return $this->repositorie_name;
    }

    public function setRepositorieName(?string $repositorie_name): self
    {
        $this->repositorie_name = $repositorie_name;

        return $this;
    }

    public function getSha(): ?string
    {
        return $this->sha;
    }

    public function setSha(?string $sha): self
    {
        $this->sha = $sha;

        return $this;
    }

    public function getCommitterName(): ?string
    {
        return $this->committer_name;
    }

    public function setCommitterName(?string $committer_name): self
    {
        $this->committer_name = $committer_name;

        return $this;
    }

    public function getCommitterEmail(): ?string
    {
        return $this->committer_email;
    }

    public function setCommitterEmail(?string $committer_email): self
    {
        $this->committer_email = $committer_email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getHtmlUrl(): ?string
    {
        return $this->html_url;
    }

    public function setHtmlUrl(?string $html_url): self
    {
        $this->html_url = $html_url;

        return $this;
    }

    public function getCommentsUrl(): ?string
    {
        return $this->comments_url;
    }

    public function setCommentsUrl(?string $comments_url): self
    {
        $this->comments_url = $comments_url;

        return $this;
    }

    public function getDateCommit(): ?\DateTimeInterface
    {
        return $this->date_commit;
    }

    public function setDateCommit(?\DateTimeInterface $date_commit): self
    {
        $this->date_commit = $date_commit;

        return $this;
    }
}
