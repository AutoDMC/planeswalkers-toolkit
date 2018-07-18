<?php
/**
 * Created by PhpStorm.
 * User: autod
 * Date: 7/15/2018
 * Time: 9:12 PM
 */

namespace MTGCli\Util;


use Symfony\Component\Yaml\Yaml;

class Stack extends Collection
{
    public function __construct($stackName) {
        $this->collectionName = $stackName;
        $fileize = str_replace('-', DIRECTORY_SEPARATOR, $this->collectionName);
        $this->filename = Configulator()['locations']['stacks'] . DIRECTORY_SEPARATOR . $fileize . '.yaml';
        if (!file_exists($this->filename)) {
            throw new \Exception("Cannot read {$this->filename}.  Does this stack exist?");
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
    public function appendCard($multiverseId, $isHolo) {
        $holoness = 'r';
        if ($isHolo) {
            $holoness = 'h';
        }
        array_push($this->data['contents'], ['mvid' => $multiverseId, 'attr' => $holoness]);
        $this->changed = true;
        $this->save();
        return count($this->data['contents']);
    }
}