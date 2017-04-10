<?php
namespace ManPhpBot;

use GuzzleHttp\ClientInterface;
use League\Flysystem\Filesystem;

/**
 * Class Download
 *
 * @package ManPhpBot
 */
class Download
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Downloader constructor.
     *
     * @param ClientInterface $client
     * @param Filesystem $filesystem
     */
    public function __construct(ClientInterface $client, Filesystem $filesystem)
    {
        $this->client = $client;
        $this->filesystem = $filesystem;
    }

    public function download()
    {
        $json = $this->client->request('GET', "http://php.net/js/search-index.php?lang=en")->getBody();

        $this->filesystem->put("en.json", $json);
    }
}
