<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FortuneRepository")
 */
class Fortune
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId() { return $this->id; }

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $creationDate;

    public function getCreationDate()              { return $this->creationDate; }
    public function setCreationDate($creationDate) { $this->creationDate = $creationDate; }

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getContent()         { return $this->content; }
    public function setContent($content) { $this->content = $content; }

    public function __construct() {
      $this->creationDate = new \DateTime();
    }
}
