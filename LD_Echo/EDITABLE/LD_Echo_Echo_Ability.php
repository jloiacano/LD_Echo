<?php

class LD_Echo_Echo_Ability
{
    // LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-SA 4.0 
    // This can be edited.

    #region // PROPERTIES

    private static ?bool $CanEcho = null;

    #endregion // PROPERTIES

    #region // GETTERS

    public static function CanEcho() {

        // IMPORTANT: To ensure you are not using this in your production environment, update self::$CanEcho to
        // check which environment you are in. Examples provided (commented out)
        // To not do so would be in violation of the license for LD_Echo.php

        if (self::$CanEcho === null) {
            self::$CanEcho = false;
            //self::$CanEcho = $_SERVER["REMOTE_ADDR"] === '::1';
            //self::$CanEcho = SiteSettings::$DisplayDevEcho;
        }

        return self::$CanEcho;
    }
    #endregion // GETTERS
}
