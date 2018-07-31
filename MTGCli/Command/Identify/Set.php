<?php // Just a sample command
namespace MTGCli\Command\Identify;
use CLIFramework\Command;
use CLIFramework\Component\Table\BorderlessTableStyle;
use CLIFramework\Component\Table\Table;
use MTGCli\CachedScryfall;
use MTGCli\Misc\UnixOutputStyle;

class Set extends Command {

    public function brief()
    {
        return 'Identify a card set by name using Scryfall.';
    }

    public function usage()
    {
        return <<<MTG

        Identify a card set by name, providing you with the set symbol
        you will need to use for other Planeswalker's Toolkit commands.
        
        The name does not have to be exact and can be fuzzy.  For example:
        "theros" => "theros tokens", "theros promos", and "theros".
        
        You will get back a list of sets that look similar to your input,
        sorted from the best match
        
        Output is:
        
        Set Symbol:Official Set Name:Percent Match Chance
MTG;
    }

    function init()
    {
        // register your subcommand here ..
    }

    function execute($setName)
    {
        $setSimilarity = $this->getSetNameSimilarity($setName);

        foreach ($setSimilarity as $percent => $set) {
            echo "{$set['code']}:{$set['name']}:{$percent}\n";
        }
    }

    function getSetNameSimilarity($setName, $numResults = null) {
        $setName = mb_strtolower($setName);
        $scry = new CachedScryfall();

        $setSimilarity = [];
        $percentIncrementer = [1 => 0];
        $percent = null;

        // We have to filter through all the mappings, because there is no convenient search function at Scryfall
        foreach ($scry->getSetMappings()['nameToCode'] as $name => $code) {
            // Let's get a percent similarity between the name we're looking for and names we get from the mappings
            similar_text($setName, $name, $percent);

            // Now we're going to make a key for the output array.  The key is the percent value, appended to by
            // an integer, because some strings come back with the exact same percentages, and we need
            // to have all results sorted.  The additional values are just a small fudge factor, I hope this
            // doesn't come back to bite me.
            $percentKey = $percent;

            // Incrementer is a HACKY HACK.  The idea is, we have an array of percent values, and every time we
            // see the same percent value, we increment the inside value by one.
            // We then format this into three digits and slap it on the end of the percent value.
            // So (for example), 33.3333% would be 33.3333001% for the first one, 33.3333002% for the second, etc.
            if (isset($percentIncrementer[$percent])) {
                // We've seen this percent, increment it.
                $percentIncrementer[$percent]++;
            } else {
                // First time, set it to 1.
                $percentIncrementer[$percent] = 1;
            }

            // Now that we have the percent incrementer, we can add the string here.
            $percentIncrementerValue = str_pad($percentIncrementer[$percent], 3, '0', STR_PAD_LEFT);

            // Concatenation here:
            // Some of these are floats, some are integers.  Of course.
            if (strpos($percentKey, '.')) {
                $percentKey .= $percentIncrementerValue;
            } else {
                $percentKey .= ".{$percentIncrementerValue}";
            }

            // Assignment here:
            $setSimilarity[$percentKey] = ['code' => $code, 'name' => $name];
        }

        krsort($setSimilarity);

        if (!is_null($numResults)) {
            return array_chunk($setSimilarity, $numResults)[0];
        } else {
            return $setSimilarity;
        }
    }
}