<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Module;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Vich\UploadableField(mapping: 'documents', fileNameProperty: 'fileName', size: 'fileSize')]
    #[Assert\File(
        detectCorrupted: true
    )]
    private ?File $File = null;

    #[ORM\Column(nullable: true)]
    private ?string $fileName = null;

    #[ORM\Column(nullable: true)]
    private ?int $fileSize = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

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

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get the value of File
     *
     * @return ?File
     */
    public function getFile(): ?File
    {
        return $this->File;
    }

    /**
     * Set the value of File
     *
     * @param ?File $File
     *
     * @return self
     */
    public function setFile(?File $File): self
    {
        $this->File = $File;

        return $this;
    }

    /**
     * Get the value of fileName
     *
     * @return ?string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @param ?string $fileName
     *
     * @return self
     */
    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of fileSize
     *
     * @return ?int
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * Set the value of fileSize
     *
     * @param ?int $fileSize
     *
     * @return self
     */
    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
