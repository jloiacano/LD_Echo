<?php

class LD_Echo_Output_Node
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    #region // PROPERTIES

    public string $type;
    public string $htmlValue;
    public string $textValue;
    public string $preTextFormatting;
    public string $postTextFormatting;

    #endregion // PROPERTIES

    public function __construct($type = null)
    {
        $this->type = $type ?? '';
        $this->htmlValue = '';
        $this->textValue = '';
        $this->preTextFormatting = '';
        $this->postTextFormatting = '';
    }


    #region // GETTERS

    public function GetHtmlValue()
    {
        return $this->preTextFormatting . $this->htmlValue;
    }

    public function GetTextValue()
    {
        return $this->textValue;
    }

    public function GetFormattedTextValue()
    {
        return $this->preTextFormatting . $this->textValue . $this->postTextFormatting;
    }

    public function GetPreTextFormatting()
    {
        return $this->preTextFormatting;
    }

    public function GetPostTextFormatting()
    {
        return $this->postTextFormatting;
    }

    #endregion // GETTERS

    #region // SETTERS
    public function SetHtmlValue($htmlValue)
    {
        $this->htmlValue = $htmlValue;
    }

    public function SetTextValue($textValue)
    {
        $this->textValue = $textValue;
    }

    public function SetPreTextFormatting($preTextFormatting)
    {
        $this->preTextFormatting = $preTextFormatting;
    }

    public function SetPostTextFormatting($postTextFormatting)
    {
        $this->postTextFormatting = $postTextFormatting;
    }
    #endregion // SETTERS
}
