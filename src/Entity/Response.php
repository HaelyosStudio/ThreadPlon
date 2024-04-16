<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $main = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $edited = null;

    /**
     * @var Collection<int, ResponseVote>
     */
    #[ORM\OneToMany(targetEntity: ResponseVote::class, mappedBy: 'response', orphanRemoval: true)]
    private Collection $responseVotes;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    private ?thread $thread = null;

    #[ORM\ManyToOne(inversedBy: 'responses')]
    private ?user $user = null;

    public function __construct()
    {
        $this->responseVotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMain(): ?string
    {
        return $this->main;
    }

    public function setMain(string $main): static
    {
        $this->main = $main;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getEdited(): ?\DateTimeInterface
    {
        return $this->edited;
    }

    public function setEdited(\DateTimeInterface $edited): static
    {
        $this->edited = $edited;

        return $this;
    }

    /**
     * @return Collection<int, ResponseVote>
     */
    public function getResponseVotes(): Collection
    {
        return $this->responseVotes;
    }

    public function addResponseVote(ResponseVote $responseVote): static
    {
        if (!$this->responseVotes->contains($responseVote)) {
            $this->responseVotes->add($responseVote);
            $responseVote->setResponse($this);
        }

        return $this;
    }

    public function removeResponseVote(ResponseVote $responseVote): static
    {
        if ($this->responseVotes->removeElement($responseVote)) {
            // set the owning side to null (unless already changed)
            if ($responseVote->getResponse() === $this) {
                $responseVote->setResponse(null);
            }
        }

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
