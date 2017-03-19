<?php

use Cocur\Slugify\Slugify as BaseSlugify;

class Slugify
{
    private $ci;
    private $slugify;

    public function __construct()
    {
        $this->ci = get_instance();
        $this->slugify = new BaseSlugify(['rulesets' => [
            'default',
            'burmese',
            'hindi',
            'georgian',
            'norwegian',
            'vietnamese',
            'ukrainian',
            'latvian',
            'finnish',
            'greek',
            'czech',
            'azerbaijani',
            'arabic',
            'polish',
            'german',
            'russian',
            'turkish',
        ]]);
    }

    public function make($string, $separator = null)
    {
        return $this->slugify->slugify($string, $separator);
    }
}
