<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;
use MTGCli\Util\Stack;

class StoreCommand extends Command {

    public function brief()
    {
        return 'Store a card in your library.';
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
        $this->command( 'stack',  '\MTGCli\Command\Store\StackCommand');
        $this->command( 'binder', '\MTGCli\Command\Store\BinderCommand');
    }

    function options($opts)
    {
        // command options

    }

    function execute()
    {
        echo "Must run `store stack` or `store binder`.";
    }
}