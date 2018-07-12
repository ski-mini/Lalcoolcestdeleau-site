<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Deck
 * 
 * @ORM\Table(name="deck")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Deck")
 */
class Deck
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
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    protected $name;

    /**
     * @var string
     * 
     * mots clefs 
     * 
     * @ORM\Column(name="keyword", type="string", nullable=true)
     */
    protected $keyword;

    /**
     * @var string
     * 
     * Description 
     * 
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Decktype")
     * @ORM\JoinColumn(name="decktype", referencedColumnName="id", nullable=false)
     */
    protected $decktype; 

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Rule", inversedBy="decks", cascade={"persist"})
     * @ORM\JoinTable(name="decks_rules",
     *      joinColumns={@ORM\JoinColumn(name="deck_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="rule_id", referencedColumnName="id")}
     * )
     * @Exclude
     */
    protected $rules;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     * @Exclude
     */
    protected $user;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Deckvisibility")
     * @ORM\JoinColumn(name="visibility", referencedColumnName="id", nullable=true)
     * @Exclude
     */
    protected $visibility;

    /**
     * @var integer
     * Nombre de DL
     * @ORM\Column(name="download", type="integer", nullable=true)
     */
    protected $download; 

    /**
     * @var float
     * Note moyenne
     * @ORM\Column(name="rate", type="float", nullable=true)
     */
    protected $rate; 

    /**
     * @var boolean
     * @ORM\Column(name="archived", type="boolean")
     * @Exclude
     */
    protected $archived;


    public function __construct()
    {
        $this->archived    =   false;
        $this->rules       =   new ArrayCollection();
    }

    /**
     * @VirtualProperty
     * @return float
     */
    public function ranking()
    {

        global $kernel;

        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }

        $service = $kernel->getContainer()->get('app.virtualiseHelper');

        return $service->getRanking($this->getDownload(), $this->getRate());

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
     * @return Deck
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
     * Set visibility
     *
     * @param boolean $visibility
     *
     * @return Deck
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return boolean
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     *
     * @return Deck
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
     * Set decktype
     *
     * @param \AppBundle\Entity\Decktype $decktype
     *
     * @return Deck
     */
    public function setDecktype(\AppBundle\Entity\Decktype $decktype)
    {
        $this->decktype = $decktype;

        return $this;
    }

    /**
     * Get decktype
     *
     * @return \AppBundle\Entity\Decktype
     */
    public function getDecktype()
    {
        return $this->decktype;
    }

    /**
     * Add rule
     *
     * @param \AppBundle\Entity\Rule $rule
     *
     * @return Deck
     */
    public function addRule(\AppBundle\Entity\Rule $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Remove rule
     *
     * @param \AppBundle\Entity\Rule $rule
     */
    public function removeRule(\AppBundle\Entity\Rule $rule)
    {
        $this->rules->removeElement($rule);
    }

    /**
     * Get rules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Deck
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
     * Set keyword
     *
     * @param string $keyword
     *
     * @return Deck
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Deck
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set download
     *
     * @param integer $download
     *
     * @return Deck
     */
    public function setDownload($download)
    {
        $this->download = $download;

        return $this;
    }

    /**
     * Get download
     *
     * @return integer
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return Deck
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer
     */
    public function getRate()
    {
        return $this->rate;
    }
}
