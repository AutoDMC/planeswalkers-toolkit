<?php // Scryfall API

namespace MTGCli;

/**
 * Class Scryfall
 * @package MTGCli
 *
 * Scryfall API object.
 *
 * Gets it's caching directory from Configulator localtions/cache
 */
class Scryfall
{
    const SCRYFALL_URL = 'https://api.scryfall.com/';

    function getByMultiverse(int $multiverseId) {
        return self::scry("cards/multiverse/{$multiverseId}");
    }

    private function scry($methodPath, $parameters = []) {
        $scryURL = self::SCRYFALL_URL . $methodPath;

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $scryURL);

        if ($res->getStatusCode() != '200') {
            throw new Exception('Could not scry!');
        }

        $scryData = $res->getBody();
        $scryPHP = json_decode($scryData, true);
        return $scryPHP;
    }
}