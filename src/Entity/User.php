<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, ResponseVote>
     */
    #[ORM\OneToMany(targetEntity: ResponseVote::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $responseVotes;

    /**
     * @var Collection<int, ThreadVote>
     */
    #[ORM\OneToMany(targetEntity: ThreadVote::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $threadVotes;

    /**
     * @var Collection<int, Response>
     */
    #[ORM\OneToMany(targetEntity: Response::class, mappedBy: 'user')]
    private Collection $responses;

    /**
     * @var Collection<int, Thread>
     */
    #[ORM\OneToMany(targetEntity: Thread::class, mappedBy: 'user')]
    private Collection $thread;

    #[ORM\Column(length: 20)]
    private ?string $username = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $edited = null;

    public function __construct()
    {
        $this->responseVotes = new ArrayCollection();
        $this->threadVotes = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->thread = new ArrayCollection();
        $this->created = new \DateTimeImmutable();
        $this->edited = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $responseVote->setUser($this);
        }

        return $this;
    }

    public function removeResponseVote(ResponseVote $responseVote): static
    {
        if ($this->responseVotes->removeElement($responseVote)) {
            // set the owning side to null (unless already changed)
            if ($responseVote->getUser() === $this) {
                $responseVote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ThreadVote>
     */
    public function getThreadVotes(): Collection
    {
        return $this->threadVotes;
    }

    public function addThreadVote(ThreadVote $threadVote): static
    {
        if (!$this->threadVotes->contains($threadVote)) {
            $this->threadVotes->add($threadVote);
            $threadVote->setUser($this);
        }

        return $this;
    }

    public function removeThreadVote(ThreadVote $threadVote): static
    {
        if ($this->threadVotes->removeElement($threadVote)) {
            // set the owning side to null (unless already changed)
            if ($threadVote->getUser() === $this) {
                $threadVote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setUser($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getUser() === $this) {
                $response->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, thread>
     */
    public function getThread(): Collection
    {
        return $this->thread;
    }

    public function addThread(thread $thread): static
    {
        if (!$this->thread->contains($thread)) {
            $this->thread->add($thread);
            $thread->setUser($this);
        }

        return $this;
    }

    public function removeThread(thread $thread): static
    {
        if ($this->thread->removeElement($thread)) {
            // set the owning side to null (unless already changed)
            if ($thread->getUser() === $this) {
                $thread->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

}
