<?php // Just a sample command
namespace MTGCli\Command\Import;
use CLIFramework\Command;
use League\Csv\Reader;
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

    function execute($importType, $path, $stackName = null)
    {
        $scry = new CachedScryfall();

        $scry->getCurrentSets();

        die();

        $csv = Reader::createFromPath($path);

        foreach ($csv->getRecords() as $offset => $record) {
            // Get set of card, based on long form set string

            // Get Multiverse ID for card based on set and name

            // Insert that card into the stack
            dump($offset);
            dump($record);
        }

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