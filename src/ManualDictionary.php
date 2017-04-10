<?php
namespace ManPhpBot;

/**
 * Class ManualDictionary
 *
 * @package ManPhpBot
 */
class ManualDictionary
{
    const MAX_RESULTS = 50;

    /**
     * @var array
     */
    protected $dictionary = [];

    /**
     * ManualDictionary constructor.
     *
     * @param array $dictionary
     */
    public function __construct(array $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * @param string $text
     * @return ManualEntity[]
     */
    public function find(string $text)
    {
        $results = array_filter($this->dictionary, function (ManualEntity $entity) use ($text) {
            return false !== mb_stripos($entity->getKey(), $text)
                || false !== mb_stripos($entity->getTopic(), $text)
                || false !== mb_stripos($entity->getDescription(), $text);
        });

        if (count($results) > self::MAX_RESULTS) {
            $results = array_slice($results, 0, self::MAX_RESULTS);
        }

        return $results;
    }
}
