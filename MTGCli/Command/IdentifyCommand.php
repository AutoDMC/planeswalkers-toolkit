<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;
use MTGCli\CachedScryfall;

class IdentifyCommand extends Command {

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
        
        Multiverse ID (tab) Set Symbol #Collector Number (tab) 'Official Name of Card'
MTG;
    }

    function init()
    {
        // register your subcommand here ..
    }

    function options($opts)
    {
        // command options

    }

    function execute($cardName, $set = null)
    {
        $scry = new CachedScryfall();

        $cardList = $scry->identifyByName($cardName, $set);

        foreach($cardList['data'] as $card) {
            echo "{$card['multiverse_ids'][0]}\t{$card['set']} #{$card['collector_number']}  \t'{$card['name']}'\n";
        }
    }
}