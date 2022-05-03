<?php

namespace App;

use App\Controllers\CommandController;
use App\Helpers\CliPrinter;
use App\Helpers\Dotenv;

class App
{
    public $printer;
    protected $command_registry;

    public function __construct()
    {
        $this->printer = new CliPrinter();
        $this->command_registry = new CommandRegistry();
    }

    public function runCommand(array $argv)
    {
        $command_name = "help";

        if (isset($argv[1])) {
            $command_name = $argv[1];
        }
        try {
            call_user_func($this->command_registry->getCallable($command_name), $argv);
        } catch (\Exception $e) {
            $this->printer->display("ERROR: " . $e->getMessage());
            exit;
        }
    }
    public function registerController($name, CommandController $controller)
    {
        $this->command_registry->registerController($name, $controller);
    }
    public function registerCommand($name, $callable)
    {
        $this->registry[$name] = $callable;
    }
    public function getCommand($command)
    {
        return isset($this->registry[$command]) ? $this->registry[$command] : null;
    }
}
