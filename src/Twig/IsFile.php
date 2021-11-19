<?php

// src/Twig/IsFile.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IsFile extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isFile', [$this, 'isFile']),
        ];
    }

    public function isFile(string $path)
    {
				// dd(getcwd() . $path);
        return file_exists($path);
    }
}

?>