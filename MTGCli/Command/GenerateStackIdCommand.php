<?php
namespace MTGCli\Command;
use CLIFramework\Command;

class GenerateSTackIdCommand extends Command {

    public function brief()
    {
        return 'Generate a stack ID.  Optionally ensure it is unique.';
    }

    public function usage()
    {
        $dc = DIRECTORY_SEPARATOR;
        return <<<MTG

Stacks are the primary means that mtg uses to track card storage.

A stack is literally a bundle of unsorted cards, stored in a defined,
named location.

This command can be used to generate a name.  Stack names are in the form:

(mana color){$dc}(planeswalker){$dc}(random 4 letter string)

So, for example, U{$dc}Chandra{$dc}a1z9

You can put this name on a deck box, a card divider, a binder, whatever
form you decide to use to store stacks.

Note that stack names are guaranteed to be unique ONLY within the set
of stacks actually stored in the database.
MTG;
    }

    function init()
    {
        shuffle($this->mana);
        shuffle($this->planeswlakers);
    }

    function execute()
    {
        $name = '';
        while ($name === '') {
            $possibleName = $this->generateName();
            if (file_exists(Configulator()['locations']['stacks'] . DIRECTORY_SEPARATOR . $possibleName)) {
                continue;
            }
            $name = $possibleName;
        }
        echo $name;
    }

    private function generateName()
    {
        $rando = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 1, 4);
        return array_pop($this->mana) . DIRECTORY_SEPARATOR . array_pop($this->planeswlakers) . DIRECTORY_SEPARATOR . $rando;
    }

    private $mana = [
        'B',
        'W',
        'R',
        'U',
        'G',
        'C',
    ];

    // List from https://magic.wizards.com/en/story/planeswalkers
    private $planeswlakers = [
        'AjaniGoldmane',
        'Angrath',
        'ArlinnKord',
        'Ashiok',
        'ChandraNalaar',
        'DackFayden',
        'Daretti',
        'DomriRade',
        'DovinBaan',
        'ElspethTirel',
        'Freyalise',
        'GarrukWildspeaker',
        'GideonJura',
        'Huatli',
        'JaceBeleren',
        'JayaBallard',
        'JiangYanggu',
        'Karn',
        'Kaya',
        'Kiora',
        'Koth',
        'MuYanling',
        'LilianaVess',
        'Nahiri',
        'Narset',
        'NicolBolas',
        'NissaRevane',
        'ObNixilis',
        'RalZarek',
        'RowanKenrith',
        'WillKenrith',
        'SaheeliRai',
        'Samut',
        'SarkhanVol',
        'SorinMarkov',
        'Tamiyo',
        'Teferi',
        'Tezzeret',
        'Tibalt',
        'Ugin',
        'Venser',
        'Vraska',
        'Xenagos',
    ];
}