<?php

namespace Cryptopro;


class Helper {

    public const RAW_CONTAINER_INFO_PATTERN = '/((^|)[A-Z]+?)[=](.*?)((?=[A-Z]+?[=])|$)/msui';

    private static function getRawInfoPattern() {
        return self::RAW_CONTAINER_INFO_PATTERN;
    }

    public static function extractValuesFromRawInfo($rawInfo) {
        $isMatch = preg_match_all(self::getRawInfoPattern(), $rawInfo, $matches);

        if (!$isMatch) {
            return null;
        }

        $keys = $matches[1];
        $values = $matches[3];

        $toReturn = [];

        foreach ($values as $valueKey => $value) {
            $toReturn[$keys[$valueKey]] = preg_replace('/[,]\s$/', '', $value);
        }

        return $toReturn;
    }

    public static function generateRandomString(
        $length = 10,
        $allowedSymbols = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $x = $allowedSymbols;

        return substr(str_shuffle(str_repeat($x, ceil($length * random_int(15, 75) / strlen($x)))), random_int(1, 14), $length);
    }

    public static function scanDirectory($directory) {
        if (is_dir($directory)) {
            return scandir($directory);
        }

        return false;
    }

    public static function createRandomDirectoryIfNotExists($parentDirectory, $directoryNameLength = 8) {
        $randomString = self::generateRandomString($directoryNameLength);

        $dirName = "{$parentDirectory}/{$randomString}";

        $directoryStructure = self::scanDirectory($dirName);
        $directoryIsExists = (boolean) $directoryStructure;

        if (!$directoryIsExists) {
            $res = self::createDirectoryIfNotExists($dirName);

            if (!$res) {
                return $res;
            } else {
                return $randomString;
            }
        } else {
            return self::createRandomDirectoryIfNotExists($parentDirectory, $directoryNameLength);
        }
    }


    public static function createDirectoryIfNotExists($dirName) {
        if (is_dir($dirName)) {
            return true;
        }

        $res = mkdir($dirName, 0777, true);

        return $res;
    }

}