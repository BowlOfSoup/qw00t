<?php

namespace Generic\Service;

class MetaService
{
    const MESSAGE_DATABASE = 'Error in database action. Try again later.';
    const PROPERTY_VALUE = 'value';
    const PROPERTY_TYPE = 'type';
    const TYPE_ERROR = 'error';

    /** @var array */
    private static $messages = array();

    /**
     * @param string $message
     * @param string $type
     */
    public static function addMessage($message, $type = 'error')
    {
        static::$messages[] = array(
            static::PROPERTY_VALUE => $message,
            static::PROPERTY_TYPE => $type,
        );
    }

    /**
     * @return bool
     */
    public static function hasMessages()
    {
        return !empty(static::$messages);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function hasMessageOfType($type)
    {
        foreach (static::$messages as $message) {
            if ($type === $message[static::PROPERTY_TYPE]) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public static function getMessages()
    {
        return static::$messages;
    }
}
