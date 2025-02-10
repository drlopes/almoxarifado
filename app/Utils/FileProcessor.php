<?php

namespace App\Utils;
use App\Traits\ProcessesFiles;

abstract class FileProcessor implements FileProcessorInterface
{
    protected static string $path;

    public static function make(string $path) : self
    {
        self::$path = $path;

        return new static;
    }
}