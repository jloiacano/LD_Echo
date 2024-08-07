<?php

class LD_Echo_Inline_Style
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-SA 4.0 
    // This can be edited.

    #region // PROPERTIES
    protected static $hasBeenIncluded = false;
    private static $style;
    #endregion // PROPERTIES

    /**
     * This is where you add your style sheets
     * These are included as text, inline, in the document
     * Use the css minimizers to avoid having to scroll through the long style tags in "View page source"
     * Try adding other styles to add inline with their corresponding stylesheets.
     */
    private static function SetStylesToInclude() {
        $stylesheetDirectory = LD_ECHO_EDITABLE_DIRECTORY . 'stylesheets' . DIRECTORY_SEPARATOR;

        $buttonStyleFileContents = file_get_contents($stylesheetDirectory .
            //'LD_Echo_oval_buttons.min.css');
            'LD_Echo-rectangle_buttons.min.css');
        $mainFileContents = file_get_contents($stylesheetDirectory .
            //'LD_Echo.css');
            'LD_Echo.min.css');
        $withTags = "\n" . '<style>' . "\n" . $buttonStyleFileContents . "\n" . $mainFileContents . '</style>' . "\n";

        self::$style = $withTags;
    }

    /**
     * This is to ensure that the inline styles from SetStylesToInclude() are only printed once in the document.
     * This is called directly in LD_Echo, so it is best to leave it alone to avoid breaking functionality.
     */
    public static function IncludeStyle()
    {
        if (self::$hasBeenIncluded == false) {
            self::SetStylesToInclude();
            echo self::$style;
            self::$hasBeenIncluded = true;
        }
    }
}
