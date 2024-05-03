<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $uniqid = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?LessonSection $lessonSection = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[ORM\Column]
    private ?int $Number = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Word::class)]
    private Collection $dictionary;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    public function __construct()
    {
        $this->dictionary = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqid(): ?string
    {
        return $this->uniqid;
    }

    public function setUniqid(string $uniqid): static
    {
        $this->uniqid = $uniqid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLessonSection(): ?LessonSection
    {
        return $this->lessonSection;
    }

    public function setLessonSection(?LessonSection $lessonSection): static
    {
        $this->lessonSection = $lessonSection;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }



    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(int $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    /**
     * @return Collection<int, Word>
     */
    public function getDictionary(): Collection
    {
        return $this->dictionary;
    }

    public function addDictionary(Word $dictionary): static
    {
        if (!$this->dictionary->contains($dictionary)) {
            $this->dictionary->add($dictionary);
            $dictionary->setLesson($this);
        }

        return $this;
    }

    public function removeDictionary(Word $dictionary): static
    {
        if ($this->dictionary->removeElement($dictionary)) {
            // set the owning side to null (unless already changed)
            if ($dictionary->getLesson() === $this) {
                $dictionary->setLesson(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }
}
