<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @Vich\Uploadable()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", nullable=false)
     */
    private $gallery;

    /**
     * @Vich\UploadableField(mapping="gallery_images", fileNameProperty="image")
     * @Assert\Expression("this.getImageFile() or this.getImage()", message="Vous devez sélectionner une photo.")     *
     * @Assert\File(
     *     maxSize="500k"
     * )
     * @Assert\Image(
     *     mimeTypes= {"image/jpg", "image/jpeg"}
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max= 30
     * )
     */
    private $place;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfLike;


    public function getId()
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $image = null)
    {
        $this->imageFile = $image;

        if ($image){
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPlace()
    {
        return $this->place;
    }

    public function setPlace(?string $place)
    {
        $this->place = $place;

        return $this;
    }

    public function __toString()
    {

    return $this->image;

    }

    public function getNumberOfLike(): ?int
    {
        return $this->numberOfLike;
    }

    public function setNumberOfLike(?int $numberOfLike): self
    {
        $this->numberOfLike = $numberOfLike;

        return $this;
    }




}
