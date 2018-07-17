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
    private $data = [];
    private $changed = false;
    private $stackName = null;
    private $filename = null;

    public function __construct($stackName) {
        $this->stackName = $stackName;
        $this->filename = Configulator()['locations']['stacks'] . DIRECTORY_SEPARATOR . $stackName;
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
        if (is_null($slotNumber)) {
            $slotNumber = $this->findNextEmptySlot();
        }
        if (!empty($this->data['contents'][$slotNumber])) {
            throw new Exception("Attempted to add a card to a slot which is already full in binder {$this->stackName}");
        }
        $this->data['contents'][$slotNumber] = ['mvid' => $multiverseId, 'attr' => $holoness];

        echo "Card inserted into slot {$slotNumber}.";
    }

    /**
     * Internal function to simply delete a specific slot.  Used when a card is removed from a stack.
     * @param $slot
     */
    private function removeCardBySlot($slot) {
        unset($this->data['contents'][$slot]);
        $this->changed = true;
        $this->save();
    }

    /**
     * Remove a given card and holo/notholo pair from a stack;  returns the specific slot number removed.
     *
     * @param $multiverseId Gatherer ID number
     * @param $isHolo True if the card being removed is a holo.
     * @return bool
     */
    public function removeCard($multiverseId, $isHolo) {
        $slot = $this->containsCard($multiverseId, $isHolo);
        if ($slot !== false) {
            $this->removeCardBySlot($slot);
            return $slot;
        } else {
            return false;
        }
    }
}