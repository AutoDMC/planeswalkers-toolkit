<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class ListCommand extends Command {

    public function brief()
    {
        return 'List stacks or decks.  (Unimplemented)';
    }

    function init()
    {
        $this->command( 'stacks' , '\MTGCli\Command\DoList\StacksCommand');
        $this->command( 'binders', '\MTGCli\Command\DoList\BindersCommand');
        // $this->command( 'list-decks',  '\MTGCli\Command\ListDecksCommand');
    }

    function options($opts)
    {
        // command options

    }

    function execute()
    {
        echo "You must run 'list stacks' or 'list decks'.";
    }
}