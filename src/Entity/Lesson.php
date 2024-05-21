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


    #[ORM\Column(length: 255, nullable: true)]
    private ?int $Number = null;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Word::class)]
    private Collection $dictionary;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\OneToOne(inversedBy: 'lesson', cascade: ['persist', 'remove'])]
    private ?Test $test = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lessonUrl = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'lessons')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Achievement::class)]
    private Collection $achievements;

    public function __construct()
    {
        $this->dictionary = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->achievements = new ArrayCollection();
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

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): static
    {
        $this->test = $test;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getLessonUrl(): ?string
    {
        return $this->lessonUrl;
    }

    public function setLessonUrl(?string $lessonUrl): static
    {
        $this->lessonUrl = $lessonUrl;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addLesson($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeLesson($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Achievement>
     */
    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    public function addAchievement(Achievement $achievement): static
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements->add($achievement);
            $achievement->setLesson($this);
        }

        return $this;
    }

    public function removeAchievement(Achievement $achievement): static
    {
        if ($this->achievements->removeElement($achievement)) {
            // set the owning side to null (unless already changed)
            if ($achievement->getLesson() === $this) {
                $achievement->setLesson(null);
            }
        }

        return $this;
    }
}
