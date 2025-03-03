<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le titre est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le titre ne doit pas dépasser 255 caractères.")]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "La date de début est obligatoire.")]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $datedebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: "La date de fin est obligatoire.")]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(propertyPath: "datedebut", message: "La date de fin doit être après la date de début.")]
    private ?\DateTimeInterface $datefin = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "Le nombre de places est obligatoire.")]
    #[Assert\Positive(message: "Le nombre de places doit être supérieur à 0.")]
    private ?int $nbrplaces = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "Veuillez entrer une URL valide.")]
    private ?string $link = null;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'formation')]
    private Collection $evaluation;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageBase64 = null;

    public function __construct()
    {
        $this->evaluation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;
        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;
        return $this;
    }

    public function getNbrplaces(): ?int
    {
        return $this->nbrplaces;
    }

    public function setNbrplaces(?int $nbrplaces): self
    {
        $this->nbrplaces = $nbrplaces;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluation(): Collection
    {
        return $this->evaluation;
    }

    public function addEvaluation($evaluation): self
    {
        if (!$this->evaluation->contains($evaluation)) {
            $this->evaluation->add($evaluation);
            $evaluation->setFormation($this);
        }
        return $this;
    }

    public function removeEvaluation($evaluation): self
    {
        if ($this->evaluation->removeElement($evaluation)) {
            if ($evaluation->getFormation() === $this) {
                $evaluation->setFormation(null);
            }
        }
        return $this;
    }

    public function getImageBase64(): ?string
    {
        return $this->imageBase64;
    }

    public function setImageBase64(?string $imageBase64): self
    {
        $this->imageBase64 = $imageBase64;
        return $this;
    }
}
