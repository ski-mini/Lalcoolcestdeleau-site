<?php

namespace AppBundle\Utils;

use Doctrine\Common\Persistence\ObjectManager;

class virtualiseHelper
{
    protected $em;

    public function setEntityManager(ObjectManager $em)
    {
       $this->em = $em;
    }


    public function getRanking($download, $rate)
    {
        $deckrepo = $this->em->getRepository('AppBundle:Deck');
        $maxDownload = $deckrepo->maxDownload();
        $maxRate = $deckrepo->maxRate();

        return ($download/$maxDownload)*100+($rate/$maxRate)*100;
    }
}