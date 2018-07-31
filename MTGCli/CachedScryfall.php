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
        $data = $this->cacheGet($key);
        if ($data === null) {
            $data = parent::getByMultiverse($multiverseId);
            $this->cachePut($key, $data, [Cache::EXPIRE => '7 days']);
        }
        return $data;
    }

    function getCurrentSets() {
        $data = $this->cacheGet('rawSets');
        if ($data === null) {
            $data = parent::getCurrentSets();
            $this->cachePut('rawSets', $data, [Cache::EXPIRE => '7 days']);
        }
        return $data;
    }

    function getSetMappings() {
        $data = $this->cacheGet('setMappings');
        if ($data === null) {
            $data = parent::getSetMappings();
            $this->cachePut('setMappings', $data, [Cache::ITEMS => ['rawSets']]);
        }
        return $data;
    }

    // Cache functions... TODO:  Break these out to a proper class?

    function cacheGet($key) {
        $data = $this->cache->load($key);
        $unpackedData = $this->unpack($data);
        return $unpackedData;
    }

    function cachePut($key, $rawData, $cacheConfiguration) {
        $data = $this->pack($rawData);
        try {
            $this->cache->save($key, $data, $cacheConfiguration);
        } catch (\Exception $e) {
            die("Oh no! {$e->getMessage()}");
        } catch (\Throwable $e) {
            die("Oh no! {$e->getMessage()}");
        }
    }

    function pack($data) {
        // return MessagePack::pack($data);
        return json_encode($data);
    }

    function unpack($data) {
        // return MessagePack::unpack($data);
        return json_decode($data, true);
    }
}