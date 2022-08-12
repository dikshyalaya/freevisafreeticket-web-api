<?php 

namespace App\Extended;

use Illuminate\Translation\Translator;

class ExtendedTranslator extends Translator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $key = mb_strtolower($key);
        return parent::get($key, $replace, $locale, $fallback);
    }
}