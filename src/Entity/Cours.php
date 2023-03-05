<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
<<<<<<< HEAD
use Doctrine\ORM\EntityManagerInterface;
=======
>>>>>>> bb4b5810e0571a8461c5ef9cc615a24bc2425ef2


/**
 * @ORM\Entity
 * @Vich\Uploadable
 * 
 */

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

<<<<<<< HEAD
    #[ORM\Column(length: 255)]
=======
    #[ORM\Column(length: 50)]
>>>>>>> bb4b5810e0571a8461c5ef9cc615a24bc2425ef2
    #[Groups(['cours'])]
    #[Assert\NotBlank (message: "nom requis") ]
  
    private ?string $nom_cours = null;

    #[ORM\Column(length: 200)]
    #[Groups(['cours'])]
    #[Assert\NotBlank (message: "activite NotBlank") ]


    private ?string $activite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"NotBlank")]
    #[Groups(['cours'])]
    private ?\DateTimeInterface $date_cours = null;

    #[Groups(['cours'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;
    
   


    
   

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Planning::class)]
    private Collection $plannings;

    public function __construct()
    {
        $this->plannings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nom_cours;
    }

    public function setNomCours($nom_cours): self
    {
        $this->nom_cours = $nom_cours;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite($activite): self
    {
        $this->activite = $activite;

        return $this;
    }
    
   
    public static function getTotalNumberOfCourses(EntityManagerInterface $entityManager)
    {
        $query = $entityManager->createQuery('SELECT COUNT(c) FROM App\Entity\Cours c');
        return $query->getSingleScalarResult();
    }

    public function getDateCours(): ?\DateTimeInterface
    {
        return $this->date_cours;
    }

    public function setDateCours(\DateTimeInterface $date_cours): self
    {
        $this->date_cours = $date_cours;

        return $this;
    }

        public function getImage(): ?string
        {
            return $this->image;
        }

<<<<<<< HEAD
            public function setImage($image): self
            {
                $this->image = $image;

                return $this;
            }
=======
        public function setImage($image): self
        {
            $this->image = $image;

            return $this;
        }
>>>>>>> bb4b5810e0571a8461c5ef9cc615a24bc2425ef2


 
    


    /**
     * @return Collection<int, Planning>
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings->add($planning);
            $planning->setCours($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getCours() === $this) {
                $planning->setCours(null);
            }
        }

        return $this;
    }
}
