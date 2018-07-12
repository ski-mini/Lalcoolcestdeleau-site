<?php

namespace AppBundle\Utils;

class Clean
{
    public function cleanRule($string, $type)
    {
        $patterns = array();
        $replacements = array();

        $patterns[0] = '#<img[^>]+Joueur1\">#';
        $patterns[1] = '#<img[^>]+Joueur2\">#';
        $patterns[2] = '#<img[^>]+Joueur3\">#';
        $patterns[3] = '#<img[^>]+Joueur4\">#';
        $patterns[4] = '#<img[^>]+Team1\">#';
        $patterns[5] = '#<img[^>]+Team2\">#';
        $patterns[6] = '#&nbsp;#';

        $replacements[0] = '$.j1';
        $replacements[1] = '$.j2';
        $replacements[2] = '$.j3';
        $replacements[3] = '$.j4';
        $replacements[4] = '$.j1';
        $replacements[5] = '$.j2';
        $replacements[6] = ' ';

        $string = preg_replace($patterns, $replacements, $string);

        $string = preg_replace('#<[^>]+>#', '', $string);

        if ($type == 1) {
            return $string;
        }
        else {
            $rule = explode('&$&$&', $string);
            $rules = '[';
            foreach ($rule as $r) {
                if(!empty($r))
                    $rules .= '"'.$r.'", ';
            }
            $rules = mb_substr($rules, 0, mb_strlen($rules)-2);
            $rules .= ']';
            return $rules;
        }
    }  
}