<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class DispelDeckCommand extends Command {

    public function brief()
    {
        return 'Deconstruct a deck, storing it in archive. (Unimplemented)';
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