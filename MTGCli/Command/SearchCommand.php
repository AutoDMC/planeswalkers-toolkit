<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class SearchCommand extends Command {

    public function brief()
    {
        return 'Search your library for a specific card. (Unimplemented)';
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