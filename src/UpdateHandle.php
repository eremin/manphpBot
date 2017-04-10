<?php
namespace ManPhpBot;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\InlineQuery\InlineQueryResultArticle;
use Telegram\Bot\Objects\InputContent\InputTextMessageContent;
use Telegram\Bot\Objects\Update;

/**
 * Class UpdateHandle
 *
 * @package ManPhpBot
 */
class UpdateHandle
{
    /**
     * @var ManualDictionary
     */
    private $dictionary;
    /**
     * @var Api
     */
    private $api;

    /**
     * UpdateHandler constructor.
     *
     * @param ManualDictionary $dictionary
     * @param Api $api
     */
    public function __construct(ManualDictionary $dictionary, Api $api)
    {
        $this->dictionary = $dictionary;
        $this->api = $api;
    }

    /**
     * @param Update $update
     */
    public function handle(Update $update)
    {
        $inlineQuery = $update->getInlineQuery();
        if ($inlineQuery && mb_strlen($inlineQuery->getQuery()) >= 3) {
            $results = $this->dictionary->find($inlineQuery->getQuery());
            $results = array_map([$this, 'mapResultsCallback'], $results);
            $this->api->answerInlineQuery([
                'inline_query_id' => $inlineQuery->getId(),
                'results' => array_values($results),
                'cache_time' => 1,
            ]);
        }
    }

    /**
     * @param ManualEntity $manualEntity
     * @return InlineQueryResultArticle
     */
    public function mapResultsCallback(ManualEntity $manualEntity): InlineQueryResultArticle
    {
        return (new InlineQueryResultArticle())
            ->setId($manualEntity->getKey())
            ->setTitle($manualEntity->getTopic())
            ->setInputMessageContent(
                (new InputTextMessageContent())
                    ->setMessageText(
                        "<b>{$manualEntity->getTopic()}</b>\n{$manualEntity->getDescription()}\n"
                        . "http://php.net/manual/en/{$manualEntity->getKey()}.php"
                    )
                    ->setParseMode('HTML')
            )
            ->setDescription($manualEntity->getDescription());
    }
}
