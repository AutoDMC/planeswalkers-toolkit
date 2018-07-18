<?php
/**
 * Created by PhpStorm.
 * User: autod
 * Date: 7/15/2018
 * Time: 9:12 PM
 */

namespace MTGCli\Util;


use Symfony\Component\Yaml\Yaml;

class Binder extends Stack
{
    public function __construct($binderName) {
        $this->collectionName = $binderName;
        $this->filename = Configulator()['locations']['binders'] . DIRECTORY_SEPARATOR . $binderName . '.yaml';
        if (!file_exists($this->filename)) {
            throw new \Exception("Cannot read {$this->filename}.  Does this stack exist?");
        }
        $this->data = Yaml::parse(file_get_contents($this->filename));
        if ($this->data['version'] != 1) {
            throw new \Exception("Cannot read version {$this->data['version']} at {$this->filename}.");
        }
    }

    public function save() {
        if ($this->changed) {
            file_put_contents($this->filename, Yaml::dump($this->data));
        }
    }

    /**
     * Loop through the slots of the data block to find an empty slot.  If you don't find an existing empty slot, add
     * one to the end.
     *
     * @return int|string
     */
    private function findNextEmptySlot() {
        $slot = 0;
        foreach ($this->data['contents'] as $row => $value) {
            if(empty($value)) {
                return $row;
            }
            $slot = $row;
        }
        return $slot + 1;
    }

    /**
     * Cards are inserted into specific slots in binders.
     *
     * @param $multiverseId Nultiverse ID of card to insert
     * @param $isHolo True if this card is holo
     * @param null $slotNumber Slot number to insert into; if null, we'll find an open slot.
     */
    public function insertCard($multiverseId, $isHolo, $slotNumber = null) {
        $holoness = 'r';
        if ($isHolo) {
            $holoness = 'h';
        }
        if ($slotNumber === '*') {
            $slotNumber = $this->findNextEmptySlot();
        }
        if (!empty($this->data['contents'][$slotNumber])) {
            throw new Exception("Attempted to add a card to a slot which is already full in binder {$this->stackName}");
        }
        $this->data['contents'][$slotNumber] = ['mvid' => $multiverseId, 'attr' => $holoness];

        echo "Card inserted into slot {$slotNumber}.";
    }
}