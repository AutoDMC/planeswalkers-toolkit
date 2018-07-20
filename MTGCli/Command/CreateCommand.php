<?php // Just a sample command
namespace MTGCli\Command;
use CLIFramework\Command;
use MTGCli\Util\Stack;
use Symfony\Component\Yaml\Yaml;

class CreateCommand extends Command {

    public function brief()
    {
        return 'Create a stack or binder for your library.';
    }

    public function usage()
    {
        $dc = DIRECTORY_SEPARATOR;
        return <<<MTG

        This lets you create a new stack or binder.
        
        If you are creating a binder you can give it a custom name;
        stacks are given a unique name.
MTG;
    }

    function init()
    {
    }

    function options($opts)
    {
        // command options

    }

    function execute($type, $name = null, $description = null)
    {
        if (!in_array($type, $this->fileTypes)) {
            throw new \Exception("Cannot create a collection of type {$type}");
        }
        $this->fileStructure['type'] = $type;

        // Only binders have a custom name...
        if ($type == 'binder') {
            $this->fileStructure['name'] = $name;
            $this->fileStructure['description'] = $description;
            $configKey = 'binders';
        } else {
            $this->fileStructure['name'] = GenerateStackIdCommand::generateName();
            $configKey = 'stacks';
        }

        $fileize = str_replace('-', DIRECTORY_SEPARATOR, $this->fileStructure['name']);
        $filename = Configulator()['locations'][$configKey] . DIRECTORY_SEPARATOR . $fileize . '.yaml';

        if (!file_exists(dirname($filename))) {
            mkdir(dirname($filename), '0777', true);
        }

        file_put_contents($filename, Yaml::dump($this->fileStructure));
        echo "{$this->fileStructure['name']} {$type} created.\n";
        return true;
    }

    private $fileTypes = [
        'stack',
        'binder',
    ];

    private $fileStructure = [
        'name' => null,
        'type' => null,
        'description' => null,
        'contents' => [
            0 => null,
        ],
        'version' => 1,
    ];
}