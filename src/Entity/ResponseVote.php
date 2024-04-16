<?php

namespace App\Entity;

use App\Repository\ResponseVoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseVoteRepository::class)]
class ResponseVote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'responseVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'responseVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?response $response = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getResponse(): ?response
    {
        return $this->response;
    }

    public function setResponse(?response $response): static
    {
        $this->response = $response;

        return $this;
    }
}
