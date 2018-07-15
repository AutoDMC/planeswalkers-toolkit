<?php // Application core bootup
namespace MTGCli;
use CLIFramework\Application;

class Console extends Application
{
    public function brief()
    {
        return "mtg is a card management program for Magic the Gathering.";
    }

    public function usage()
    {
        return <<<MTG

mtg manages Decks, Stacks, and Binders in your Library.

Decks are descriptions of specific playable decks; you can Summon or Dispel
these decks at will.  If your stacks have been properly maintained, Summon will
even figure out the most efficient way for you to pull cards for your deck!

Stacks represent the storage of your card library.  A stack can be stored any way
you wish, but should be an ordered stack of cards with a unique name and
location.  The Stacks organizer does not require your card collection to be
presorted;  computers are really, really good at tracking lots of messy data and
humans are really, really bad at keeping large collections organized.

Binders represent collection binders, sets of cards you do not want to use for
decks or trade.

mtg can also generate tradelists, allowing you to advertise the specific cards
you are willing to trade for.  By marking registered decks as "desired," mtg
can even provide a list of "wants" for your collection!
MTG;
    }

    /* init your application options here */
    public function options($opts)
    {
    $opts->add('d|debug', 'Dump debug messages to console?');
    // $opts->add('path:', 'required option with a value.');
    // $opts->add('path?', 'optional option with a value');
    // $opts->add('path+', 'multiple value option.');
    }

    /* register your command here */
    public function init()
    {
    parent::init();

    Configulator()->loadFile('config.yaml');

    $this->command( 'search','\MTGCli\Command\SearchCommand' );
    $this->command( 'store', '\MTGCli\Command\StoreCommand');
    $this->command( 'pull',  '\MTGCli\Command\PullCommand');

    $this->command( 'register',  '\MTGCli\Command\RegisterDeckCommand');
    $this->command( 'summon',  '\MTGCli\Command\SummonDeckCommand');
    $this->command( 'dispel',  '\MTGCli\Command\DispelDeckCommand');

    $this->command( 'list',  '\MTGCli\Command\ListCommand');
    $this->command( 'dump',  '\MTGCli\Command\DumpCommand');

    $this->command( 'generate-stack-id',  '\MTGCli\Command\GenerateStackIdCommand');
    // $this->command( 'bar' );    // initialize with \YourApp\Command\BarCommand
    }
}