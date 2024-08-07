<?php

class LD_Echo_Script
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    #region // PROPERTIES
    private static $hasBeenIncluded = false;

    private static $javaScriptToInclude;
    
    private static function SetJavaScriptToInclude() {
        $fileContents = file_get_contents(LD_ECHO_MAIN_DIRECTORY .
            'javascript' . DIRECTORY_SEPARATOR .
            //'LD_Echo.js');
            'LD_Echo.min.js');
        $withTags = "\n" . '<script>' . "\n" . $fileContents . '</script>' . "\n";
        self::$javaScriptToInclude = $withTags;
    }

    #endregion // PROPERTIES

    public static function IncludeScript()
    {
        if (self::$hasBeenIncluded == false) {
            self::SetJavaScriptToInclude();
            echo self::$javaScriptToInclude;
            self::$hasBeenIncluded = true;
        }
    }
}
