<?php // Just a sample command
namespace MTGCli\Command\Identify;
use CLIFramework\Command;
use CLIFramework\Prompter;
use GuzzleHttp\Exception\RequestException;
use MTGCli\CachedScryfall;

class Card extends Command {

    public function brief()
    {
        return 'Identify a card by name using Scryfall.';
    }

    public function usage()
    {
        return <<<MTG

        Identify a card by name, providing you with the Multiverse ID
        you will need to use for other Planeswalker's Toolkit commands.
        
        The name does not have to be exact and can be fuzzy.  For example:
        "fountain renew" => "Fountain of Renewal" from Core 2019
        "pacif" => "Every version of Pacifism"
        
        You can provide this command with the card name, and you'll get
        a list of all cards that share that name.
        
        You can optionally provide a set symbol, which will only return
        the card that belonged to that set, if it exists.
        
        Output is:
        
        Multiverse ID (tab) Set Symbol #Collector Number (tab) 'Official Name of Card.php'
MTG;
    }

    function execute($cardName, $set = null)
    {
        $cardData = $this->identifyByName($cardName, $set);
        if (is_null($cardData)) {
            echo "Could not identify {$cardName} from {$set}.";
        }
        foreach($this->identifyByName($cardName, $set) as $card) {
            if (empty($card['multiverse_ids'])) {
                continue;
            }
            echo "{$card['multiverse_ids'][0]}:{$card['set']}:{$card['collector_number']}:{$card['name']}\n";
        }
    }

    function identifyByName($cardName, $set = null) {
        $scry = new CachedScryfall();

        try {
            $cardList = $scry->identifyByName($cardName, $set);
        } catch (RequestException $re) {
            return null;
        }

        return $cardList['data'];
    }
}