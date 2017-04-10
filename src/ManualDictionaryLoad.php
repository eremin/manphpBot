<?php
namespace ManPhpBot;

use Doctrine\Common\Cache\CacheProvider;
use League\Flysystem\Filesystem;
use function \GuzzleHttp\json_decode;

/**
 * Class ManualDictionaryLoad
 *
 * @package ManPhpBot
 */
class ManualDictionaryLoad
{
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var CacheProvider
     */
    private $cacheProvider;
    /**
     * @var string
     */
    private $prefix;

    /**
     * ManualDictionaryLoad constructor.
     *
     * @param Filesystem $filesystem
     * @param CacheProvider $cacheProvider
     * @param string $prefix
     */
    public function __construct(Filesystem $filesystem, CacheProvider $cacheProvider, string $prefix)
    {
        $this->filesystem = $filesystem;
        $this->cacheProvider = $cacheProvider;
        $this->prefix = $prefix;
    }

    /**
     * @return ManualDictionary
     */
    public function load() : ManualDictionary
    {
        if ($this->cacheProvider->contains("{$this->prefix}en")) {
            return $this->cacheProvider->fetch("{$this->prefix}en");
        }
        $manualDictionary = $this->loadFromFilesystem();
        $this->cacheProvider->save("{$this->prefix}en", $manualDictionary, 3600);
        return $manualDictionary;
    }

    /**
     * @return ManualDictionary
     */
    private function loadFromFilesystem(): ManualDictionary
    {
        $jsonContent = $this->filesystem->read('en.json');
        $json = json_decode($jsonContent, true);

        $dictionary = [];

        foreach ($json as $key => $array) {
            $dictionary[$key] = new ManualEntity($key, $array[0], $array[1]);
        }

        return new ManualDictionary($dictionary);
    }
}
