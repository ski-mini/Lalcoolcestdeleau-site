<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Exclude;

/**
 * Rule
 * 
 * @ORM\Table(name="rule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Rule")
 */
class Rule
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
     * @ORM\Column(name="text", type="string", nullable=false)
     */
    protected $text;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ruletype")
     * @ORM\JoinColumn(name="ruletype", referencedColumnName="id", nullable=false)
     */
    protected $ruletype; 

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Deck", mappedBy="rules", cascade={"persist"})
     * @Exclude
     */
    private $decks;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     * @Exclude
     */
    protected $user;

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean")
     * @Exclude
     */
    protected $archived;


    public function __construct()
    {
        $this->archived    =   false;
        $this->decks       =   new ArrayCollection();
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
     * Set text
     *
     * @param string $text
     *
     * @return Rule
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        if($this->ruletype->getId() == 1)
            return $this->text;
        else{
            $text = json_decode($this->text);
            return $text;
        }
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Rule
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

    /**
     * Set ruletype
     *
     * @param \AppBundle\Entity\Ruletype $ruletype
     *
     * @return Rule
     */
    public function setRuletype(\AppBundle\Entity\Ruletype $ruletype)
    {
        $this->ruletype = $ruletype;

        return $this;
    }

    /**
     * Get ruletype
     *
     * @return \AppBundle\Entity\Ruletype
     */
    public function getRuletype()
    {
        return $this->ruletype;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Rule
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add deck
     *
     * @param \AppBundle\Entity\Deck $deck
     *
     * @return Rule
     */
    public function addDeck(\AppBundle\Entity\Deck $deck)
    {
        $this->decks[] = $deck;

        return $this;
    }

    /**
     * Remove deck
     *
     * @param \AppBundle\Entity\Deck $deck
     */
    public function removeDeck(\AppBundle\Entity\Deck $deck)
    {
        $this->decks->removeElement($deck);
    }

    /**
     * Get decks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDecks()
    {
        return $this->decks;
    }
}
