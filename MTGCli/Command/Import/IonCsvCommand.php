<?php // Just a sample command
namespace MTGCli\Command\Import;
use CLIFramework\Command;
use League\Csv\Reader;
use MTGCli\CachedScryfall;
use MTGCli\Command\Identify\Card;
use MTGCli\Command\Identify\Set;
use MTGCli\Util\Stack;


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

    function execute($path)
    {
        $scry = new CachedScryfall();

        $scry->getCurrentSets();
        $scry->getSetMappings();

        $csv = Reader::createFromPath($path);
        $csv->setHeaderOffset(0);

        $stack = new Stack();
        $unidentifiedCards = [];
        $identifiedCardCount = 0;

        foreach ($csv->getRecords() as $offset => $record) {
            // Get set of card, based on long form set string
            $setSeek = new Set();
            $bestGuessSet = array_shift($setSeek->getSetNameSimilarity($record['Edition']))['code'];

            // Get Multiverse ID for card based on set and name
            $cardSeek = new Card();
            $cardProbablyIs = $cardSeek->identifyByName($record['Cardname'], $bestGuessSet)[0];
            if (is_null($cardProbablyIs)) {
                $unidentifiedCards[] = [ 'name' => $record['Cardname'], 'set' => $record['Edition'], 'setGuess' => $bestGuessSet ];
                continue;
            }

            // Holo?
            $holo = false;
            if ($record['Foil'] === 'True') {
                $holo = true;
            }

            // Insert that card into the stack
            $stack->appendCard($cardProbablyIs['multiverse_ids'][0], $holo, "{$record['Cardname']} - {$record['Edition']} ({$bestGuessSet})");

            $identifiedCardCount++;
        }

        echo $stack->getName() . " has been created.  {$identifiedCardCount} cards identified.\n";
        if (!empty($unidentifiedCards)) {
            echo "There were problems identifying cards: \n";
            foreach ($unidentifiedCards as $card) {
                echo "- {$card['name']} from {$card['set']} (Guessed: {$card['setGuess']})\n";
            }
            echo "Manually add these cards to the stack, or fix the CSV, delete the stack, and try again.";
        }
    }
}