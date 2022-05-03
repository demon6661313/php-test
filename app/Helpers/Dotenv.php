<?php

namespace App\Helpers;

class Dotenv
{
    private function setEnvs($content)
    {
        $vars = explode("\n", $content);
        foreach ($vars as $var) {
            putenv($var);
        }
    }

    public function load($path)
    {
        $content = file_get_contents($path);
        $this->setEnvs($content);
    }
}
