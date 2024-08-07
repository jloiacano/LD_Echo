<?php

class LD_Echo_HTML
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    #region // PROPERTIES
    private static $ldEchoTitleBarHTML;
    #endregion // PROPERTIES

    #region // METHODS

    /**
     * helps to format comments (mainly for div closes)
     * @param mixed $htmlComment 
     * @return mixed A formatted html comment in comment brackets
     */
    public static function GetHTMLComment($htmlComment) {
        if ($htmlComment != null && strpos($htmlComment, '-->') === false) {
            $htmlComment = ' <!-- ' . $htmlComment . ' -->';
        }
        return $htmlComment;
    }

    /**
     * Gets the LD_Echo_Output_Node of the console div open
     * @return LD_Echo_Output_Node
     */
    public static function GetEchoConsoleMainDivOpen()
    {
        $nodeToReturn = new LD_Echo_Output_Node('Main Div Open');
        $html = 
            "<!-- START LD_Echo CONSOLE -->\r" .
            '<div class="echo-console-container limited-console">';
        $nodeToReturn->SetHtmlValue($html);
        $nodeToReturn->SetPostTextFormatting("\r");
        return $nodeToReturn;
    }

    public static function GetEchoConsoleTitleBar($title)
    {
        $nodeToReturn = new LD_Echo_Output_Node('Title Bar HTML');

        $titleTextStyles = array();
        if (($titleColor = LD_Echo_Style::GetTitleColor()) != null) {
            $titleTextStyles[] = 'color: ' . $titleColor . ';';
        }
        $titleBarStyles = array();
        if (($titleBarBackground = LD_Echo_Style::GetTitleBackgroundColor()) != null) {
            $titleBarStyles[] = 'background-color: ' . $titleBarBackground . ';';
        }

        if (self::$ldEchoTitleBarHTML == null)
        {
        	self::$ldEchoTitleBarHTML = file_get_contents(
                LD_ECHO_MAIN_DIRECTORY .
                'html' . DIRECTORY_SEPARATOR .
                'consoleTitleBar.html');
        }
        
        $html = self::$ldEchoTitleBarHTML . "\r";
        $html = str_replace('$titleBarStyles', implode(' ', $titleBarStyles), $html);
        $html = str_replace('$titleTextStyles', implode(' ', $titleTextStyles), $html);
        $html = str_replace('$title', $title, $html);

        $nodeToReturn->SetHtmlValue($html);
        $nodeToReturn->SetTextValue($title);
        $nodeToReturn->SetPostTextFormatting("\r");
        return $nodeToReturn;
    }

    public static function GetEchoConsoleDisplayDivOpen()
    {
        $consoleDisplayStyles = array();
        if (($color = LD_Echo_Style::GetConsoleDisplayColor()) != null) {
            $consoleDisplayStyles[] = 'color: ' . $color . ';';
        }
        if (($backgroundColor = LD_Echo_Style::GetConsoleDisplayBackgroundColor()) != null) {
            $consoleDisplayStyles[] = 'background-color: ' . $backgroundColor . ';';
        }

        $nodeToReturn = new LD_Echo_Output_Node('Console Div Open');
        $html = '<div class="echo-console-display" style="' . implode(' ', $consoleDisplayStyles) . '">' . "\r";
        $nodeToReturn->SetHtmlValue($html);
        $nodeToReturn->SetPostTextFormatting("\r");
        return $nodeToReturn;
    }

    public static function GetEchoConsoleHiddenTextArea($ld_echo_output_nodes) {
        $outputNodesToFormattedText = '';
        foreach ($ld_echo_output_nodes as $echoOutputNode) {
            $outputNodesToFormattedText = $outputNodesToFormattedText . $echoOutputNode->GetFormattedTextValue();
        }

        $nodeToReturn = new LD_Echo_Output_Node('Hidden Text Area Node');
        $hiddenStyle = ' style="height: 0px; display: none;"';
        $html =
            "\r<!-- END CONSOLE DISPLAY -->\r\r" .
            "\r<!-- START HIDDEN TEXT AREA -->\r" .
            '<textarea class="hidden-console-text-area" ' . $hiddenStyle . '>' . 
            $outputNodesToFormattedText .
            '</textarea>' .
            "\r<!-- END HIDDEN TEXT AREA -->\r";

        $nodeToReturn->SetHtmlValue($html);
        $nodeToReturn->SetPostTextFormatting("\r");
        return $nodeToReturn;
    }

    public static function GetEchoConsoleLineDivOpen($htmlComment = null)
    {
        $htmlComment = self::GetHTMLComment($htmlComment);

        $nodeToReturn = new LD_Echo_Output_Node('Console Line Open');
        $tabs = LD_Echo_Tabs::AddTab();
        $nodeToReturn->SetPreTextFormatting($tabs);
        $html = $tabs . '<div class="echo-console-line">' . "\r";
        $nodeToReturn->SetHtmlValue($html);
        //$nodeToReturn->SetPostTextFormatting("\r");
        return $nodeToReturn;
    }

    public static function GetEchoTextNodeOpen($text)
    {
        $nodeToReturn = new LD_Echo_Output_Node('Text Echo');
        $tabs = LD_Echo_Tabs::GetTabs();
        $nodeToReturn->SetPreTextFormatting($tabs);
        LD_Echo_Tabs::AddTab();

        $nodeToReturn->SetHtmlValue(self::GetEchoTextNodeOpenHTML($text, $tabs));


        $nodeToReturn->SetTextValue($text);
        $nodeToReturn->SetPostTextFormatting("\r");

        return $nodeToReturn;
    }

    private static function GetEchoTextNodeOpenHTML($text, $tabs) {
        $htmls = array();
        $htmls[] = '<div class="echo-console-line">' . "\r";

        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(1) . '<span class="collapsable" title="Collapse">' . "\r";

        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(2) . '<span class="up-arrow">' . "\r";
        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(3) . '&#x25B2;&nbsp;' . "\r";
        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(2) . '</span>' . "\r";

        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(2) . '<span class="down-arrow">' . "\r";
        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(3) . '&#x25BC;&nbsp;' . "\r";
        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(2) . '</span>' . "\r";

        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(2) . $text . "\r";

        $htmls[] = $tabs . LD_Echo_Tabs::MakeXTabs(1) . '</span>' . "\r";

        return implode(' ', $htmls);
    }

    public static function GetEchoConsoleDivClose($htmlComment = null)
    {
        $htmlComment = self::GetHTMLComment($htmlComment);

        $nodeToReturn = new LD_Echo_Output_Node('Close Div');
        $tabs = LD_Echo_Tabs::RemoveTab();
        $html = $tabs .'</div>' . $htmlComment . "\r";
        $nodeToReturn->SetHtmlValue($html);
        return $nodeToReturn;
    }

    public static function GetEchoConsoleDisplayAndContainerDivClose() {
        $nodeToReturn = new LD_Echo_Output_Node('Close Div');
        $html = "\t</div> <!-- echo-console-display -->\r" .
            "</div><!-- echo-console-container -->\r" .
            "<!-- END LD_Echo CONSOLE -->\r";
        $nodeToReturn->SetHtmlValue($html);
        return $nodeToReturn;
    }
    #endregion // METHODS
}