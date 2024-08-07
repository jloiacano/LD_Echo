<?php

class LD_Echo_Tabs {
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    private static $tabs = false;

    public static function GetTabCount()
    {
        if (self::$tabs === false) {
            return -1;
        }

        return count(self::$tabs);
    }

    public static function GetTabs()
    {
        $tabsToReturn = '';
        if (self::$tabs !== false) {
            $tabsToReturn = implode('', self::$tabs);
        }

        return $tabsToReturn;
    }

    public static function AddTab()
    {
        //skip the first open to avoid unnecessary indenting on first line
        if (self::$tabs === false) {
            self::$tabs = array();
        }
        else {
            self::$tabs[] = "\t";
        }

        return implode('', self::$tabs);
    }

    public static function RemoveTab()
    {
        if (self::$tabs !== false && count(self::$tabs) === 0) {
            self::$tabs = false;
        } 
        else {
            array_pop(self::$tabs);
            return implode('', self::$tabs);
        }
    }

    public static function MakeXTabs(int $x) {
        $tabsToReturn = "";
        for ($i = 0; $i < $x; $i++) {
            $tabsToReturn = $tabsToReturn . "\t";
        }
        return $tabsToReturn;
    }

    public static function ResetAllTabsToNone()
    {
        self::$tabs = false;
    }
}
