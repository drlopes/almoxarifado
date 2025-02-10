<?php

namespace App\Utils;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

final class ExcelFileProcessor extends FileProcessor
{
    public static function getdata(bool $associative = true) : bool|array|string
    {
        return self::read(path: self::$path, associative: $associative);
    }

    private static function read(string $path, $associative = true) : bool|array|string
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray('-', true, true, true, true);

        // Remove empty rows
        $rows = array_filter($rows, function ($row) {
            return ! empty(array_filter($row));
        });

        // Remove empty columns
        $rows = array_map(function ($row) {
            return array_filter($row, function ($value) {
                return ! is_null($value);
            });
        }, $rows);

        // pop the header
        $header = array_shift($rows);

        // make the header the index for the rows
        $rows = array_map(function ($row) use ($header) {
            return array_combine($header, $row);
        }, $rows);

        return $associative ? $rows : json_encode($rows);
    }
}