<?php // Just a sample command
namespace MTGCli\Command\Store;
use CLIFramework\Command;
use MTGCli\Util\Binder;
use MTGCli\Util\Stack;

class BinderCommand extends Command {

    public function brief()
    {
        return 'Store a card in your library. (Unimplemented)';
    }

    public function usage()
    {
        $dc = DIRECTORY_SEPARATOR;
        return <<<MTG

        This allows you to add a single card to a binder.
        
        Adding a card to a binder adds that card to a specific slot within the
        binder.
        
        You must provide a slot number to insert the card into;  if you don't 
        care, and simply want to fill the first available slot, provide 0
        as the slot number.  (Slots should start with #1, so #0 is obvious.)
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

    function execute($stackName, $slot, $multiverseId, $isHolo = false)
    {
        $stack = new Binder($stackName);

        $slot = $stack->insertCard($multiverseId, $isHolo, $slot);
    }
}