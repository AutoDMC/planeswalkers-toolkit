<?php
namespace MTGCli\Command;
use CLIFramework\Command;
use Symfony\Component\Yaml\Yaml;

class ImportStackCommand extends Command {

    private $incomingFile = '';

    public function brief()
    {
        return 'Import a stack from a deck file produced by another program.';
    }

    public function usage()
    {
        return <<<MTG
Stacks are the primary means that mtg uses to track card storage.

        To speed up inserting cards into storage, we can use a program like Decked
        Builder or TCGPlayer to build a "deck file" using photo capture.

        You can then inject this "deck file" as a stack into the card archive.

        You will get back the name of the stack assigned by mtg.
        
        The "path" parameter is the path to the file you want to import.

        You should only import a stack once this way, or else you'll have a bad
        time.  If you DO accidentally import a file more than once, you just need
        to delete the additional file from the stacks.
MTG;
    }

    public function arguments($args) {
        $args->add('path')
            ->desc('path to file you want to import (drag and drop it onto your terminal)');
    }

    function init()
    {
    }

    function execute($path)
    {
        $pathinfo = pathinfo($path);

        if ($pathinfo['extension'] == 'coll2') {
            $parsed = file_get_contents($path);
            dump($parsed);
        }
    }
}