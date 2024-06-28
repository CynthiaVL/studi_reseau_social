<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Post {

    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column(type:"integer")]
    private int $id;

    #[ORM\Column(type:'string', length:50)]
    private string $title;

    #[ORM\Column(type:'text', length:300)]
    private string $content;

    #[ORM\Column(type:'string', nullable:true)]
    private ?string $image = NULL;

    #[ORM\ManyToOne(targetEntity:'App\Entity\User', inversedBy :'posts')]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id", onDelete:"CASCADE")]
    private $user;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of image
    */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
        dump($user);
    }

}

