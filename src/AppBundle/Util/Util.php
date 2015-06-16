<?php

namespace AppBundle\Util;
class Util
{
    static public function getSlug($string, $separator = '-')
    {
        //TODO: Meter slug en todas las entidades
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separator));
        $slug = preg_replace("/[\/_|+ -]+/", $separator, $slug);
        return $slug;
    }
}