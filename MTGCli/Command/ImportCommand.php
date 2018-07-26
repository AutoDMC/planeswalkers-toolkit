<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;

class ImportCommand extends Command {

    public function brief()
    {
        return 'Import a binder or stack.';
    }

    public function usage()
    {
        return <<<MTG

        Import a file as a binder or stack.
MTG;
    }

    public function init()
    {
        $this->command( 'ion-csv', '\MTGCli\Command\Import\IonCsvCommand');
    }

    function execute()
    {
        echo "Have to specify a binder or stack!";
    }
}