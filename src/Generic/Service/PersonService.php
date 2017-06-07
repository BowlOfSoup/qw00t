<?php

namespace Generic\Service;

class PersonService
{
    /**
     * Correctly outputs Dutch names.
     *
     * @param string $name
     *
     * @return string
     */
    static public function transformName($name)
    {
        $prefixLowercase = array('van', 'der', 'de');
        $preparedName = null;

        $i = 1;
        $parts = explode(' ', strtolower($name));
        foreach($parts as $part) {
            if ($i > 1) {
                $preparedName .= ' ';
            }
            (!in_array($part, $prefixLowercase)) ? $preparedName .= ucwords($part) : $preparedName .= $part;
            ++$i;
        }

        return $preparedName;
    }
}
