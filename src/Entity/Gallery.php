<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max= 30
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="gallery", cascade={"all"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->createDate = new \dateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Image $image
     * @return Gallery
     */
    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $image->setGallery($this);
            $this->images[] = $image;
        }

        return $this;
    }

    /**
     * @param Image $image
     * @return Gallery
     */
    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getGallery() === $this) {
                $image->setGallery(null);
            }
        }

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

}
