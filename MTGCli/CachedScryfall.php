<?php
namespace MTGCli;

use MessagePack\MessagePack;
use Nette\Caching\Cache;
use Nette\Caching\Storages\SQLiteStorage;


/**
 * Just like Scryfall, but it uses caching!
 *
 * Keys for the cache are:  {name of function}:{parameter list separated by commas}
 *
 * Class CachedScryfall
 * @package MTGCli
 */
class CachedScryfall extends Scryfall
{

    private $cache = null;

    function __construct() {
        $storage = new SQLiteStorage(Configulator()['locations']['cache']);
        $this->cache = new Cache($storage, 'scryfall');
    }

    function getByMultiverse(int $multiverseId) {
        $key = "getByMultiverse:{$multiverseId}";
        $data = $this->cache->load($key);
        if ($data === null) {
            $scryResult = parent::getByMultiverse($multiverseId);
            $data = MessagePack::pack($scryResult);
            $this->cache->save($key, $data, [Cache::EXPIRE => '24 hours']);
        }
        return MessagePack::unpack($data);
    }

    // TODO:  Make a cache function?
}