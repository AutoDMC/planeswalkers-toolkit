<?php // Just a sample command
namespace MTGCli\Command\Import;
use CLIFramework\Command;
use MTGCli\CachedScryfall;

class IonCsvCommand extends Command {

    public function brief()
    {
        return 'Import a CSV file from ION Scanner.';
    }

    public function usage()
    {
        return <<<MTG

        Import a CSV file exported by ION Scanner.
        
        Import as a binder or a stack.
        
        ION Scanner comes from Quiet Speculation http://quietspeculation.com/
MTG;
    }

    function execute($importType, $path)
    {
        $scry = new CachedScryfall();

        $parsed = file_get_contents($path);
        dump($parsed);

        // Store Binder

        // Store Stack

        // Store Deck (Stack + Decklist)

        /*
        $cardList = $scry->identifyByName($cardName, $set);

        foreach($cardList['data'] as $card) {
            echo "{$card['multiverse_ids'][0]}\t{$card['set']} #{$card['collector_number']}  \t'{$card['name']}'\n";
        }
        */
    }
}