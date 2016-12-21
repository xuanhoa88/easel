<?php

namespace Canvas\Helpers;

use Schema;

class SetupHelper extends CanvasHelper
{
    /**
     * Ensure all required tables exist;.
     */
    public static function requiredTablesExists()
    {
        foreach (self::REQUIRED_TABLES as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Whether canvas is properly set up/installed.
     * @return bool|bool
     */
    public static function isSetUp()
    {
        return self::requiredTablesExists();
    }

    /**
     * Whether canvas is properly installed.
     * @return bool|bool
     */
    public static function isInstalled()
    {
        return self::isSetUp();
    }
}
