<?php
/**
 * Created by PhpStorm.
 * User: autod
 * Date: 7/15/2018
 * Time: 9:12 PM
 */

namespace MTGCli\Util;


use MTGCli\Command\CreateCommand;
use MTGCli\Command\GenerateStackIdCommand;
use Symfony\Component\Yaml\Yaml;

class Stack extends Collection
{
    public function __construct($stackName = null) {
        if (is_null($stackName)) {
            // New Stack!
            $creator = new CreateCommand();
            $stack = $creator->createCollection('stack');
            $this->collectionName = $stack['name'];
            $this->filename = $stack['filename'];
        } else {
            $this->collectionName = $stackName;
            $fileize = str_replace('-', DIRECTORY_SEPARATOR, $this->collectionName);
            $this->filename = Configulator()['locations']['stacks'] . DIRECTORY_SEPARATOR . $fileize . '.yaml';
            if (!file_exists($this->filename)) {
                throw new \Exception("Cannot find a file named {$this->filename}.  Does it exist?");
            }
        }
        $this->data = Yaml::parse(file_get_contents($this->filename));
        if ($this->data['version'] != 1) {
            throw new \Exception("Cannot read version {$this->data['version']} at {$this->filename}.");
        }
    }

    /**
     * In Stacks, we want to re-stack the contents so that numbers are consecutive.
     */
    public function save() {
        $this->data['contents'] = array_values($this->data['contents']);
        parent::save();
    }

    /**
     * Append a card to this stack.
     *
     * @param $multiverseId Gatherer ID Number
     * @param $isHolo Is this card a holofoil?
     *
     * @return int Slot number of inserted card.
     */
    public function appendCard($multiverseId, $isHolo, $verbose = null) {
        $holoness = 'r';
        if ($isHolo) {
            $holoness = 'h';
        }

        $cardRecord = ['mvid' => $multiverseId, 'attr' => $holoness];
        if (!is_null($verbose)) {
            $cardRecord['verboseInfo'] = $verbose;
        }

        array_push($this->data['contents'], $cardRecord);
        $this->changed = true;
        $this->save();
        return count($this->data['contents']);
    }
}