<?php

class LD_Echo_Style
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    #region // PROPERTIES
    private static $titleColor;
    private static $titleBackgroundColor;
    private static $consoleDisplayColor;
    private static $consoleDisplayBackgroundColor;
    #endregion // PROPERTIES

    #region // GETTERS

    public static function GetTitleColor()
    {
        return self::$titleColor;
    }

    public static function GetTitleBackgroundColor()
    {
        return self::$titleBackgroundColor;
    }

    public static function GetConsoleDisplayColor()
    {
        return self::$consoleDisplayColor;
    }

    public static function GetConsoleDisplayBackgroundColor()
    {
        return self::$consoleDisplayBackgroundColor;
    }
    #endregion // GETTERS

    #region // SETTERS

    public static function SetTitleColor($color)
    {
        self::$titleColor = $color;
    }

    public static function SetTitleBackgroundColor($color)
    {
        self::$titleBackgroundColor = $color;
    }

    public static function SetConsoleDisplayColor($color)
    {
        self::$consoleDisplayColor = $color;
    }

    public static function SetConsoleDisplayBackgroundColor($color)
    {
        self::$consoleDisplayBackgroundColor = $color;
    }

    public static function ResetDefaults()
    {
        self::$titleColor = null;
        self::$titleBackgroundColor = null;
        self::$consoleDisplayColor = null;
        self::$consoleDisplayBackgroundColor = null;
    }
    #endregion // SETTERS
}
