<?php // Application core bootup
namespace MTGCli;
use CLIFramework\Application;

class Console extends Application
{
    /* init your application options here */
    public function options($opts)
    {
    // $opts->add('v|verbose', 'verbose message');
    // $opts->add('path:', 'required option with a value.');
    // $opts->add('path?', 'optional option with a value');
    // $opts->add('path+', 'multiple value option.');
    }

    /* register your command here */
    public function init()
    {
    parent::init();
    // $this->command( 'list', '\YourApp\Command\ListCommand' );
    // $this->command( 'foo', '\YourApp\Command\FooCommand' );
    // $this->command( 'bar' );    // initialize with \YourApp\Command\BarCommand
    }
}