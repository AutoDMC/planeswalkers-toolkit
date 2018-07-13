<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class DumpCommand extends Command {

    public function brief()
    {
        return 'Dump the contents of a stack. (Unimplemented)';
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