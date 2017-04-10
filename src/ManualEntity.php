<?php
namespace ManPhpBot;

/**
 * Class ManualEntity
 *
 * @package ManPhpBot
 */
class ManualEntity
{
    /**
     * @var string
     */
    private $key;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @var string
     */
    private $topic;
    /**
     * @var string
     */
    private $description;

    /**
     * ReferenceEntity constructor.
     *
     * @param string $key
     * @param string $topic
     * @param string $description
     */
    public function __construct(string $key, string $topic, string $description)
    {
        $this->key = $key;
        $this->topic = $topic;
        $this->description = $description;
    }
}
