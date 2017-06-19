<?php

namespace Generic\Service;

class ArrayService
{
    /** @var array */
    private $propertyMapping = array();

    /**
     * @param array $propertyMapping
     */
    public function __construct(array $propertyMapping)
    {
       $this->propertyMapping = $propertyMapping; 
    }

    /**
     * @param array $properties
     * 
     * @return array
     */
    public function map(array $properties)
    {
        if (!empty($properties) && !array_key_exists(0, $properties)) {
            $properties = $this->mapProperties($properties);
        } else {
            $properties = $this->mapPropertyCollection($properties);
        }
        
        return $properties;
    }
    
    /**
     * Prepares properties before they're being set on a Response.
     *
     * @param array $properties
     *
     * @return array
     */
    private function mapPropertyCollection(array $properties)
    {
        foreach ($properties as $key => $item) {
            $properties = $this->mapProperties($properties, $key);
        }

        return $properties;
    }

    /**
     * Maps property names for a Response.
     *
     * @param array $properties
     * @param string|int|null $parentKey
     *
     * @return array
     */
    private function mapProperties(array $properties, $parentKey = null)
    {
        if (empty($this->propertyMapping)) {
            return $properties;
        }

        foreach ($this->propertyMapping as $originalKey => $replacementKey) {
            if (null !== $parentKey) {
                if (null === $replacementKey) {
                    unset($properties[$parentKey][$originalKey]);

                    continue;
                }

                $properties[$parentKey][$replacementKey] = $properties[$parentKey][$originalKey];
                unset($properties[$parentKey][$originalKey]);
            } else {
                if (null === $replacementKey) {
                    unset($properties[$originalKey]);

                    continue;
                }

                $properties[$replacementKey] = $properties[$originalKey];
                unset($properties[$originalKey]);
            }
        }

        ksort($properties);

        return $properties;
    }
}
