<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

/**
 * Ruletype
 * 
 * @ORM\Table(name="ruletype")
 * @ORM\Entity
 */
class Ruletype
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * 
     * Nom 
     * 
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Exclude
     */
    protected $name;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean")
     * @Exclude
     */
    protected $archived;


    public function __construct()
    {
        $this->archived    =   false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Ruletype
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Ruletype
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }
}
