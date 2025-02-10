<?php

namespace App\Utils;

interface FileProcessorInterface
{
    public static function make(string $path) : self;
    public static function getdata(bool $associative = true) : bool|array|string;
}