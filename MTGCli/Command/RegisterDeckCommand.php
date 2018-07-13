<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class RegisterDeckCommand extends Command {

    public function brief()
    {
        return 'Register a playable deck into the archive. (Unimplemented)';
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