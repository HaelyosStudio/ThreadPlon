<?php

namespace App\Entity;

use App\Repository\ThreadVoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadVoteRepository::class)]
class ThreadVote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $vote = null;

    #[ORM\ManyToOne(inversedBy: 'threadVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?thread $thread = null;

    #[ORM\ManyToOne(inversedBy: 'threadVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isVote(): ?bool
    {
        return $this->vote;
    }

    public function setVote(bool $vote): static
    {
        $this->vote = $vote;

        return $this;
    }

    public function getThread(): ?thread
    {
        return $this->thread;
    }

    public function setThread(?thread $thread): static
    {
        $this->thread = $thread;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
