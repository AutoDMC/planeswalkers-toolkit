<?php
/**
 * Created by PhpStorm.
 * User: autod
 * Date: 7/15/2018
 * Time: 9:12 PM
 */

namespace MTGCli\Util;


use Symfony\Component\Yaml\Yaml;

class Stack
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
            $this->data['contents'] = array_values($this->data['contents']);
            file_put_contents($this->filename, Yaml::dump($this->data));
        }
    }

    public function getName() {
        return $this->data['name'];
    }
    public function setName($name) {
        $this->data['name'] = $name;
        $this->changed = true;
    }

    public function getLocation() {
        return $this->data['location'];
    }
    public function setLocation($location) {
        $this->data['location'] = $location;
        $this->changed = true;
    }

    public function getDescription() {
        return $this->data['description'];
    }
    public function setDescription($description) {
        $this->data['description'] = $description;
        $this->changed = true;
    }

    /**
     * Search through this stack to see if it contains a specific multiverse id (gatherer card)
     *
     * @param $multiverseId Gatherer ID number
     * @param bool $isHolo Looking for a Holofoil?
     * @return bool True if this stack contains the card.
     */
    public function containsCard($multiverseId, $isHolo = false) {
        $attribute = 'r'; // Regular card
        if ($isHolo) {
            $attribute = 'h'; // Holo card
        }
        foreach ($this->data['contents'] as $slot => $cardData) {
            if ($cardData['mvid'] == $multiverseId && $cardData['attr'] == $attribute) {
                return $slot + 1; // Because humans don't like to index 0;
            }
        }
        return false;
    }

    /**
     * Append a card to this stack.
     *
     * @param $multiverseId Gatherer ID Number
     * @param $isHolo Is this card a holofoil?
     */
    public function appendCard($multiverseId, $isHolo) {
        $holoness = 'r';
        if ($isHolo) {
            $holoness = 'h';
        }
        array_push($this->data['contents'], ['mvid' => $multiverseId, 'attr' => $holoness]);
        $this->changed = true;
        $this->save();
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