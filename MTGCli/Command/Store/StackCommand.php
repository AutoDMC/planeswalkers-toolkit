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

        This allows you to add a single card to a stack.
        
        Adding a card to a stack appends the card to the end (bottom) of the
        stack.
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