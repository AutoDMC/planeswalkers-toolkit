<?php
/**
 * Created by PhpStorm.
 * User: autod
 * Date: 7/15/2018
 * Time: 9:12 PM
 */

namespace MTGCli\Util;


use Symfony\Component\Yaml\Yaml;

class Binder extends Collection
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
        if (!empty($this->data['contents'])) {
            // Let's make sure this file wasn't messed up outside of Planeswalker's Toolkit.
            ksort($this->data['contents']);
        }
    }

    /**
     * In Stacks, we want to re-stack the contents so that numbers are consecutive.
     */
    public function save() {
        ksort($this->data['contents']);
        // $this->data['contents'] = array_reverse($this->data['contents'], true);
        parent::save();
    }

    /**
     * Loop through the slots of the data block to find an empty slot.  If you don't find an existing empty slot, add
     * one to the end.
     *
     * @return int|string
     */
    private function findNextEmptySlot() {
        if (empty($this->data['contents'])) {
            return 1;
        }
        $lastSeen = 0;
        foreach ($this->data['contents'] as $row => $value) {
            $row = str_replace('#', '', $row);
            dump("looking at {$row}, the last row I saw was {$lastSeen}.");
            // We're looking for gaps.  If this row number is more than +1 of the last number we saw, then there is
            // a gap!  Let's give the gap number:
            if ($row > $lastSeen + 1) {
                return $lastSeen + 1;
            }
            $lastSeen = $row;
        }
        // Whelp, we went through the whole list... no gaps!  Let's send the next slot:
        return $lastSeen + 1;
    }

    /**
     * Cards are inserted into specific slots in binders.
     *
     * We have to kludge around the auto-sorting feature of YAML by forcing string keys, in the format of #IIII
     *
     * @param $multiverseId Nultiverse ID of card to insert
     * @param $isHolo True if this card is holo
     * @param $slotNumber Slot number to insert into; if null, we'll find an open slot.
     *
     * @throws \Exception
     *
     * @return $slotNumber The slot number inserted.
     */
    public function insertCard($multiverseId, $isHolo, $slotNumber = 0) {
        $holoness = 'r';
        if ($isHolo) {
            $holoness = 'h';
        }
        if ($slotNumber == 0) {
            $slotNumber = $this->findNextEmptySlot();
        } // dump("I have found slot number " . $slotNumber);
        if (!empty($this->data['contents']["$slotNumber"])) {
            throw new \Exception("Attempted to add a card to a slot which is already full in binder {$this->stackName}");
        }
        $slotNumber = "#" . str_pad($slotNumber, 4, " ", STR_PAD_LEFT);
        $this->data['contents'][$slotNumber] = ['mvid' => $multiverseId, 'attr' => $holoness];
        // dump($this->data);
        $this->changed = true;
        $this->save();
        // After save!
        // dump($this->data);

        echo "Card.php inserted into slot {$slotNumber}.\n";
        return $slotNumber;
    }
}