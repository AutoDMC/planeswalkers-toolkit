<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class PullCommand extends Command {

    public function brief()
    {
        return 'Pull a specific card out of your library. (Unimplemented)';
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