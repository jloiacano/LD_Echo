<?php

abstract class LD_Echo
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-ND 4.0 

    #region // PARENT ONLY FUNCTIONAL PROPERTIES

    private static $debugBacktrace;
    private static $additionalHint;
    private static $echoOutputNodes = array();

    #endregion // PARENT ONLY FUNCTIONAL PROPERTIES

    #region // GETTERS

    /**
     * Part of ObtainTitle functionality.
     * Gets the debug backtrace index of the last call.
     * @return int Integer index of the call
     */
    private static function GetIndexOfInitialCall()
    {

        $lastIndex = 0;

        foreach (self::$debugBacktrace as $trace) {
            if (array_key_exists('class', $trace)) {
                $class = $trace['class'];
                $reflection = new ReflectionClass($class);
                if ($class == 'LD_Echo' || $reflection->isSubclassOf('LD_Echo')) {
                    $lastIndex = $lastIndex + 1;
                } else {
                    $lastIndex = $lastIndex - 1;
                    break;
                }
            }
        }

        return $lastIndex;
    }

    /**
     * Obtains the text for the title bar of the console, or first line of the formatted string.
     * By default, title contains ">>>> - LD_Echo - <<<<"
     * If applicable, title contains the class, function name, and line from which it is called.
     * Will add optional $additionalHint after closing arrows if provided.
     * @return string The full title
     */
    private static function ObtainTitle()
    {
        //$indexOfCall = self::GetIndexOfInitialCall();
        //$indexExists = array_key_exists($indexOfCall, self::$debugBacktrace);
        //$nextIndexExists = array_key_exists($indexOfCall + 1, self::$debugBacktrace);
        //$nextIndexIsFromAClass = $nextIndexExists && array_key_exists('class', self::$debugBacktrace[$indexOfCall + 1]);

        $insideText = array();
        $headerOpener = '>>>> ';
        $headerCloser = ' <<<<';
        $insideText[] = $headerOpener;

        //if ($nextIndexIsFromAClass) { // called from a class function
        //    $insideText[] = self::$debugBacktrace[$indexOfCall + 1]['class'];
        //    if (array_key_exists('function', self::$debugBacktrace[$indexOfCall + 1])) {
        //        $insideText[] = self::$debugBacktrace[$indexOfCall + 1]['function'];
        //    }
        //    if (array_key_exists('line', self::$debugBacktrace[$indexOfCall + 1])) {
        //        $insideText[] = '[' . self::$debugBacktrace[$indexOfCall]['line'] . ']';
        //    }
        //} else if ($indexExists) {
        //    $hasFileKey = array_key_exists('file', self::$debugBacktrace[$indexOfCall]);
        //    $hasLineKey = array_key_exists('line', self::$debugBacktrace[$indexOfCall]);
        //    if ($hasFileKey) {
        //        $insideText[] = self::$debugBacktrace[$indexOfCall]['file'];
        //    } else {
        //        $insideText[] = 'LD_Echo';
        //    }
        //    if ($hasLineKey) {
        //        $insideText[] = '[' . self::$debugBacktrace[$indexOfCall]['line'] . ']';
        //    }
        //} else {
        //    $insideText[] = 'LD_Echo';
        //}
        $insideText[] = 'LD_Echo';


        $insideText[] = $headerCloser;

        if (self::$additionalHint != null) {
            $insideText[] = self::$additionalHint;
        }

        return implode(' - ', $insideText);
    }

    #endregion // GETTERS

    #region // SETTERS

    /**
     * Adds an LD_Echo_Output_Node to the array of output nodes which will make up the echo.
     * @param LD_Echo_Output_Node $echoOutputNode node to be added to the main array.
     */
    protected static function AddOutputNode(LD_Echo_Output_Node $echoOutputNode)
    {
        self::$echoOutputNodes[] = $echoOutputNode;
    }
    #endregion // SETTERS

    #region // METHODS

    /**
     * Inital setup function which handles debug backtrace and additional hint setup.
     * @param mixed $additionalHint (optional) optional text to be displayed next to title in the console title bar.
     */
    private static function InitalizeEchoersFunctionality($additionalHint)
    {
        if (self::$debugBacktrace == null) {
            self::$debugBacktrace = debug_backtrace();
        }

        if ($additionalHint != null) {
            self::$additionalHint = $additionalHint;
        }
    }

    /**
     * Makes sure that $toEcho contains an actual value to Echo.
     * Not null, or empty string, or empty array.
     * @param mixed $toEcho 
     * @return mixed The $toEcho value, or its nullable explanation if applicable.
     */
    private static function ValidateToEcho($toEcho)
    {
        $toEchoType = gettype($toEcho);

        if ($toEcho === null) {
            LD_Echo_Style::SetConsoleDisplayColor('yellow');
            $toEcho = 'NULL --- (LD_Echo() was sent a null value to echo)';
        }
        if ($toEchoType == 'string' && trim($toEcho) === '') {
            LD_Echo_Style::SetConsoleDisplayColor('yellow');
            $toEcho = 'EMPTY STRING --- (LD_Echo() was sent an empty string value to echo)';
        }
        if ($toEchoType == 'array' && count($toEcho) === 0) {
            LD_Echo_Style::SetConsoleDisplayColor('yellow');
            $toEcho = 'EMPTY ARRAY --- (LD_Echo() was sent an empty array to echo)';
        }
        return $toEcho;
    }

    #region // PROTECTED ECHOERS MAIN CALLS

    /**
     * SUPERCHARGED echo
     * Handles arrays, even if they are serialized! No more var_dump for you! 
     * Only shows up in where you want it when configured in descendants.
     * Contains backtrace class description and color options.
     * Shows up in functional "Console" which is configurable in the descendants.
     * @param mixed $toEcho That which would like to be echoed.
     * @param string $additionalHint (optional) optional text to be displayed next to title in the console title bar.
     */
    protected static function Echo($toEcho, string $additionalHint = null)
    {
        $toEcho = self::ValidateToEcho($toEcho);
        self::InitalizeEchoersFunctionality($additionalHint);

        echo LD_Echo_Inline_Style::IncludeStyle();
        echo LD_Echo_Script::IncludeScript();

        try {
            self::GatherOutputElements($toEcho);
            self::EchoOutputNodesToConsole();
        } catch (Exception $exception) {
            echo 'Oops. There was an error in LD_Echo while trying to Echo :';
            var_dump($toEcho);

            throw $exception;
        } finally {
            self::Reset();
        }
    }

    /**
     * SUPERCHARGED echo
     * Handles arrays, even if they are serialized! No more var_dump for you! 
     * Only shows up in where you want it when configured in descendants.
     * Contains backtrace class description and color options.
     * Gets the string with all formatting characters present: \t for tabs and \n for newlines.
     * <HINT> when calling from subclass, use <pre></pre> to wrap returned value (example in Dev::EchoToString())
     * @param mixed $toEcho That which would like to be echoed.
     * @param string $additionalHint (optional) optional text to be displayed next to title in the console title bar.
     * @return string $toEcho as string with all formatting characters present: \t for tabs and \n for newlines.
     */
    protected static function GetFormattedString($toEcho, string $additionalHint = null)
    {
        $toEcho = self::ValidateToEcho($toEcho);
        self::InitalizeEchoersFunctionality($additionalHint);
        $formattedTextToReturn = '';

        try {
            self::GatherOutputElements($toEcho);
            $formattedTextToReturn = self::GetOutputNodesToFormattedText();
        } catch (Exception $exception) {
            $formattedTextToReturn = 'Oops. There was an error in LD_Echo while trying to Echo :';
            var_dump($toEcho);
        } finally {
            self::Reset();
            return $formattedTextToReturn;
        }
    }

    /**
     * SUPERCHARGED echo
     * Handles arrays, even if they are serialized! No more var_dump for you! 
     * Only shows up in where you want it when configured in descendants.
     * Contains backtrace class description and color options.
     * @param mixed $toEcho That which would like to be echoed.
     * @param string $additionalHint (optional) optional text to be displayed next to title in the console title bar.
     * @return string $toEcho as string WITHOUT ANY formatting characters present. Just one continuous string.
     */
    protected static function EchoToUnformattedString($toEcho, string $additionalHint = null)
    {
        $toEcho = self::ValidateToEcho($toEcho);
        self::InitalizeEchoersFunctionality($additionalHint);
        $formattedTextToReturn = '';

        try {
            self::GatherOutputElements($toEcho);
            $formattedTextToReturn = self::GetOutputNodesToPlainText();
        } catch (Exception $exception) {
            $formattedTextToReturn = 'Oops. There was an error in LD_Echo while trying to Echo :';
            var_dump($toEcho);
        } finally {
            self::Reset();
            return $formattedTextToReturn;
        }
    }

    #endregion // PROTECTED ECHOERS MAIN CALLS

    /**
     * Does the main work of parsing $toEcho and generating all the LD_Echo_Output_Node elements
     * with text, formatted text, and html text variants.
     * @param mixed $toEcho That which would like to be echoed.
     */
    private static function GatherOutputElements($toEcho)
    {
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleMainDivOpen());
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleTitleBar(self::ObtainTitle()));
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDisplayDivOpen());

        self::EchoLocate($toEcho);

        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleHiddenTextArea(self::$echoOutputNodes));

        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDisplayAndContainerDivClose());
    }

    private static function EchoOutputNodesToConsole()
    {
        foreach (self::$echoOutputNodes as $echoOutputNode) {
            echo $echoOutputNode->GetHtmlValue();
        }
    }

    /**
     * Internal function to get gathered string with all formatting characters present
     * @return string gathered string with all formatting characters present
     */
    private static function GetOutputNodesToFormattedText()
    {
        $outputNodesToFormattedText = '';
        foreach (self::$echoOutputNodes as $echoOutputNode) {
            $outputNodesToFormattedText = $outputNodesToFormattedText . $echoOutputNode->GetFormattedTextValue();
        }
        return $outputNodesToFormattedText;
    }

    /**
     * Internal function to get gathered string WITHOUT ANY formatting characters present
     * @return string gathered string WITHOUT ANY formatting characters present
     */
    private static function GetOutputNodesToPlainText()
    {
        $outputNodesToFormattedText = '';
        foreach (self::$echoOutputNodes as $echoOutputNode) {
            $outputNodesToFormattedText = $outputNodesToFormattedText . $echoOutputNode->GetTextValue();
        }
        return $outputNodesToFormattedText;
    }

    private static function EchoOutputNodesToFormattedText()
    {
        foreach (self::$echoOutputNodes as $echoOutputNode) {
            echo $echoOutputNode->GetFormattedTextValue();
        }
    }

    private static function EchoOutputNodesToUnformattedText()
    {
        foreach (self::$echoOutputNodes as $echoOutputNode) {
            echo $echoOutputNode->GetTextValue();
        }
    }

    /**
     * The main chooser of which way to Echo $toEcho
     * @param mixed $toEcho 
     */
    private static function EchoLocate($toEcho)
    {
        switch (gettype($toEcho)) {
            case 'object':
                self::EchoObject($toEcho);
                break;
            case 'array':
                self::EchoArray($toEcho);
                break;
            default:
                self::AddOutputNode(LD_Echo_HTML::GetEchoTextNodeOpen($toEcho));
                self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('string Div Close'));
        }
    }

    private static function EchoArray(array $array)
    {
        $array = self::GetUnserialized($array);

        foreach ($array as $key => $arrayElement) {
            $notPrintableTypes = array("array", "object", "resource");
            $arrayElementType = gettype($arrayElement);
            if (in_array($arrayElementType, $notPrintableTypes)) {
                self::EchoKeyWithComplexValuePair($key, $arrayElement);
            } else {
                if ($arrayElementType == 'boolean') {
                    $arrayElement = $arrayElement == 1 ? 'true' : 'false';
                }
                self::EchoKeyWithStringValuePair($key, (string) $arrayElement);
            }
        }
    }

    private static function EchoKeyWithStringValuePair(string $key, string $value)
    {
        $pairText = LD_Echo_HTML::GetEchoTextNodeOpen('[' . $key . '] = ' . $value);
        self::AddOutputNode($pairText);
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('EchoTextNodeClose'));
    }

    private static function EchoKeyWithComplexValuePair(string $key, $value)
    {
        $keyText = LD_Echo_HTML::GetEchoTextNodeOpen('[' . $key . ']');
        self::AddOutputNode($keyText);
        self::EchoLocate($value);
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('indexed array close'));
    }

    private static function EchoObject(object $object)
    {
        $class = get_class($object);

        self::AddOutputNode(LD_Echo_HTML::GetEchoTextNodeOpen('OBJECT: ' . $class));

        $reflectionClass = new ReflectionClass($object);
        self::EchoObjectConstants($reflectionClass);
        self::EchoObjectProperties($object, $reflectionClass);
        self::EchoObjectMethods($object, $reflectionClass);
        self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('OBJECT close'));
    }

    private static function EchoObjectConstants(ReflectionClass $reflectionClass)
    {
        $constants = $reflectionClass->getConstants();
        if (count($constants) > 0) {
            self::AddOutputNode(LD_Echo_HTML::GetEchoTextNodeOpen('CONSTANTS: '));
            self::EchoLocate($constants);
            self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('CONSTANTS Div Close'));
        }
    }

    private static function EchoObjectProperties(object $object, ReflectionClass $reflectionClass)
    {
        $properties = $reflectionClass->getProperties();

        if (count($properties) > 0) {
            self::AddOutputNode(LD_Echo_HTML::GetEchoTextNodeOpen('PROPERTY VALUES: '));

            foreach ($properties as $reflectionProperty) {
                $propertyKeyValueToEcho = array();
                $key = array();
                $value = null;


                if ($reflectionProperty->isPublic()) {
                    $key[] = 'public';
                    $value = $reflectionProperty->getValue($object);
                } else if ($reflectionProperty->isPrivate()) {
                    $reflectionProperty->setAccessible(true);
                    $key[] = 'private';
                    $value = $reflectionProperty->getValue($object);
                    $reflectionProperty->setAccessible(false);
                } else if ($reflectionProperty->isProtected()) {
                    $key[] = 'protected';
                    $value = $reflectionProperty->getValue($object);
                }

                if ($reflectionProperty->isStatic()) {
                    $key[] = 'static';
                }

                $key[] = $reflectionProperty->getName();

                $propertyKeyValueToEcho[implode(' ', $key)] = $value;
                self::EchoLocate($propertyKeyValueToEcho);
            }

            self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('PROPERTY VALUES Div Close'));
        }
    }

    private static function EchoObjectMethods(object $object, ReflectionClass $reflectionClass)
    {
        $methods = $reflectionClass->getMethods();

        if (count($methods) > 0) {
            self::AddOutputNode(LD_Echo_HTML::GetEchoTextNodeOpen('METHODS: '));
            foreach ($methods as $reflectionMethod) {
                $methodArrayToEchoLocate = array();

                $accessibilityAndKeywords = implode(' ', Reflection::getModifierNames($reflectionMethod->getModifiers()));
                $name = $reflectionMethod->getName();
                $parameters = self::GetMethodParametersForSignature($reflectionMethod);
                self::GetMethodReturnType($reflectionClass, $object, $reflectionMethod);

                $signature = $accessibilityAndKeywords . ' ' . $name . $parameters;
                self::EchoLocate($signature);
            }
            self::AddOutputNode(LD_Echo_HTML::GetEchoConsoleDivClose('METHODS Div Close'));
        }
    }

    private static function GetMethodParametersForSignature($reflectionMethod)
    {
        $parameters = array();

        $reflectionParameters = $reflectionMethod->getParameters();
        foreach ($reflectionParameters as $reflectionParameter) {
            $parameter = array();
            if ($reflectionParameter->getType() != null) {
                $parameter[] = $reflectionParameter->getType()->getName();
            }
            $parameter[] = $reflectionParameter->getName();
            $parameters[] = implode(' ', $parameter);
        }

        return "(" . implode(', ', $parameters) . ")";
    }

    private static function GetUnserialized($possiblySerialized)
    {
        $data = @unserialize($possiblySerialized);
        if ($data !== false) {
            $possiblySerialized = $data;
        }
        return $possiblySerialized;
    }

    /**
     * Essential functionality at end of any Echoer to clear everything for future calls.
     */
    private static function Reset()
    {
        LD_Echo_Style::ResetDefaults();
        LD_Echo_Tabs::ResetAllTabsToNone();
        self::$debugBacktrace = null;
        self::$additionalHint = null;
        self::$echoOutputNodes = array();
    }

    /**
     * NOT YET FUNCTIONAL - DO NOT CALL
     * @param mixed $reflectionClass 
     * @param mixed $object 
     * @param mixed $reflectionMethod 
     */
    private static function GetMethodReturnType($reflectionClass, $object, $reflectionMethod)
    {
        //TODO for vs. 1.1 : see if I cant find the return types of the methods...
        // https://www.php.net/manual/en/reflectionclass.getmethods.php
        // https://www.php.net/manual/en/class.reflectionmethod.php
        // HAS  /* Inherited methods */
        //      public ReflectionFunctionAbstract::getReturnType(): ?ReflectionType
        //      https://www.php.net/manual/en/reflectionfunctionabstract.getreturntype.php
        // $reflectionMethod->getReturnType() does not work. Always returns null.
    }

    /**
     * NOT YET USED -  FUTURE FUNCTIONALITY
     */
    private static function EchoDebugTrace()
    {
        self::EchoArray(self::$debugBacktrace);
    }

    #endregion // METHODS
}
