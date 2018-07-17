<?php // Just a sample command
namespace MTGCli\Command\Store;
use CLIFramework\Command;
use MTGCli\Util\Stack;

class StackCommand extends Command {

    public function brief()
    {
        return 'Store a card in your library. (Unimplemented)';
    }

    public function usage()
    {
        $dc = DIRECTORY_SEPARATOR;
        return <<<MTG

        This allows you to add a single card to a stack or a binder.
        
        Adding a card to a stack appends the card to the end (bottom) of the
        stack.
        
        Adding a card to a binder adds that card to a specific slot within the
        binder.
        
        You can provide an optional slot number when adding to a binder, or
        the command will provide you with the slot number to place the card
        in. 
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

    function execute($stackName, $multiverseId, $isHolo = false)
    {
        $stack = new Stack($stackName);

        $slot = $stack->appendCard($multiverseId, $isHolo);

        echo $slot;
    }
}