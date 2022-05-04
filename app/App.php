<?php

namespace App;

use App\Controllers\Cli\CommandController;
use App\Controllers\Cli\RedisCliController;
use App\Controllers\Controller;
use App\Helpers\CliPrinter;
use App\Helpers\Dotenv;
use App\Router\Router;
use Lib\Http\Request;

class App
{
    public $printer;
    protected Router $router;
    protected $command_registry;

    public function __construct()
    {
        $this->printer = new CliPrinter();
        $this->router = new Router();
        $this->command_registry = new CommandRegistry();
    }
    public function getRouter()
    {
        return $this->router;
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
    public function handle(Request $request)
    {
        if (!$this->matchRoute($request)) {
        }
    }

    private function matchRoute(Request $request)
    {
        $match = null;
        $uriArr = explode('/', $request->uri);
        foreach ($this->router->getRoutes()[$request->method] as $pattern => $callable) {
            if ($match) {
                break;
            }
            $patternArr = explode('/', $pattern);
            if (count($uriArr) != count($patternArr)) {
                continue;
            }
            foreach ($patternArr as $key => $value) {

                if (str_starts_with($value, '{')) {
                    preg_match('/\{(\w+?)\}/', $value, $matches);
                    if (isset($matches[1])) {
                        $request->{$matches[1]} = $uriArr[$key];
                    }
                    continue;
                }
                if ($value != $uriArr[$key]) {
                    break;
                }

                if ($key == count($patternArr) - 1) {
                    $match = $callable;
                }
            }
        }
        $controller = new $callable[0]($this);
        $controller->{$callable[1]}($request);

        return false;
    }
}
