<?php

namespace Generic\Service;

/**
 * You can use this class to store meta messages used in e.g. a Response.
 */
class MetaService
{
    const MESSAGE_DATABASE = 'Error in database action. Try again later.';
    const PROPERTY_VALUE = 'value';
    const PROPERTY_TYPE = 'type';
    const TYPE_ERROR = 'error';

    /** @var array */
    private static $messages = array();

    /**
     * Add a message to the meta bag.
     *
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
     * Returns if there are messages in this bag.
     *
     * @return bool
     */
    public static function hasMessages()
    {
        return !empty(static::$messages);
    }

    /**
     * Check if a message exists in this bag for a certain type.
     *
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
     * Get messages stored in this bag.
     *
     * @return array
     */
    public static function getMessages()
    {
        return static::$messages;
    }
}
