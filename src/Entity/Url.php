<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Url
 * @package App\Entity
 * @ORM\Table("urls")
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     * @var AbstractUid $id
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @ORM\Column(type="text")
     * @var string $path
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface $createdAt
     */
    private $createdAt;

    /**
     * Url constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->createdAt = new DateTime();
    }

    /**
     * @return AbstractUid
     */
    public function getId(): AbstractUid
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
