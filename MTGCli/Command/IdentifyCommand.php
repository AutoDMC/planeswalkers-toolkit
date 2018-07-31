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

        Identify a card or set using Scryfall.
        
        You should use the "card" or "set" subcommand as necessary.
MTG;
    }

    function init()
    {
        $this->command('set',  '\MTGCli\Command\Identify\Set');
        $this->command('card', '\MTGCli\Command\Identify\Card');
    }

    function execute($cardName, $set = null)
    {
        echo "Identify a 'set' or a 'card'?";
    }
}