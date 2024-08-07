<?php

class Dev extends LD_Echo
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-SA 4.0 
    // This can be edited.

    /**
     * {@inheritdoc}
     * 
     * @param mixed $toEcho That which you would like to be echoed... 
     *  - string? of course. 
     *  - An array? Sure! 
     *  - A complex object? You betcha!
     *  - But, but, but, it's serialized... NO WORRIES! We got your back.
     * @param string $additionalHint (optional) optional text to be displayed next to title in the console title bar.
     * @param string $titleColor (optional) Sets the colore of the html console display's title.
     *  - use hex value (#FFFFFF) or color name ('white'). 
     *  - Some allowed colors: {@link https://en.wikipedia.org/wiki/Web_colors#Extended_colors}
     *  
     */
    public static function Echo($toEcho, string $additionalHint = null, string $titleColor = null)
    {
        if (LD_Echo_Echo_Ability::CanEcho()) {
            if ($titleColor != null) {
                LD_Echo_Style::SetTitleColor($titleColor);
            }

            parent::Echo($toEcho, $additionalHint);
        }
    }

    /**
     * Echos to a formatted string of whatever is being echoed
     * This is like normal LD_Echo, but does not show up in the 'console' nor provide collapsing functionality.
     * @param mixed $toEcho That which you would like to be echoed... 
     * @param string|null $additionalHint (optional) optional text to be displayed next to title line of the text.
     */
    public static function EchoToString($toEcho, string $additionalHint = null)
    {
        if (LD_Echo_Echo_Ability::CanEcho()) {
            $formattedTextToEcho = parent::GetFormattedString($toEcho, $additionalHint);
            echo "<pre style='font-weight: normal;'>" . $formattedTextToEcho . "</pre>";
        }
    }
}