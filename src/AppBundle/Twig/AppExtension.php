<?php

namespace AppBundle\Twig;

use Symfony\Component\Asset\Packages;

class AppExtension extends \Twig_Extension
{

    protected $assets;

    public function __construct(Packages $packages)
    {
        $this->assets = $packages;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('beautifulRule', array($this, 'beautifulRule')),
        );
    }

    public function beautifulRule($string, $decktype)
    {
        $patterns = array();
        $replacements = array();

        $patterns[0] = '#\$\.j1#';
        $patterns[1] = '#\$\.j2#';
        $patterns[2] = '#\$\.j3#';
        $patterns[3] = '#\$\.j4#';

        if($decktype == 1) {
            $replacements[0] = '<img src="'.$this->assets->getUrl("bundles/app/images/joueur1.png").'" class="j1Img" style="height:17px;width:54px;" alt="Joueur1" />';
            $replacements[1] = '<img src="'.$this->assets->getUrl("bundles/app/images/joueur2.png").'" class="j2Img" style="height:17px;width:54px;" alt="Joueur2" />';
            $replacements[2] = '<img src="'.$this->assets->getUrl("bundles/app/images/joueur3.png").'" class="j3Img" style="height:17px;width:54px;" alt="Joueur3" />';
            $replacements[3] = '<img src="'.$this->assets->getUrl("bundles/app/images/joueur4.png").'" class="j4Img" style="height:17px;width:54px;" alt="Joueur4" />';
        }
        else {
            $replacements[0] = '<img src="'.$this->assets->getUrl("bundles/app/images/equipe1.png").'" class="t1Img" style="height:17px;width:54px;" alt="Equipe1" />';
            $replacements[1] = '<img src="'.$this->assets->getUrl("bundles/app/images/equipe2.png").'" class="t2Img" style="height:17px;width:54px;" alt="Equipe2" />';
            $replacements[2] = '';
            $replacements[3] = '';
        }
       

        return preg_replace($patterns, $replacements, $string);

    }  
}