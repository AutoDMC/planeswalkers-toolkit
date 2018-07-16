<?php // Just a sample command
namespace MTGCli\Command\Show;
use CLIFramework\Command;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Symfony\Component\Yaml\Yaml;

class StacksCommand extends Command {

    public function brief()
    {
        return 'List registered stacks.';
    }

    function init()
    {
    }

    function options($opts)
    {
    }

    function execute()
    {
        $directory = new \RecursiveDirectoryIterator(Configulator()['locations']['stacks'], \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new \RecursiveIteratorIterator($directory, \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($iterator as $file) {
            $stack = Yaml::parse(file_get_contents($file->getRealPath()));
            echo "{$stack['name']} - {$stack['description']}\n";
        }
    }
}