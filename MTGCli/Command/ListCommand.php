<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class ListCommand extends Command {

    public function brief()
    {
        return 'awesome help brief.';
    }

    function init()
    {
        // register your subcommand here ..
    }

    function options($opts)
    {
        // command options

    }

    function execute($arg1,$arg2,$arg3 = 0)
    {
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

        $input = $this->ask('Please type something');

    }
}