<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class StoreCommand extends Command {

    public function brief()
    {
        return 'Store a card in your library. (Unimplemented)';
    }

    function init()
    {
        // register your subcommand here ..
    }

    function options($opts)
    {
        // command options

    }

    function execute()
    {
        $logger = $this->logger;

        $logger->info('Command not implemented yet!');
    }
}