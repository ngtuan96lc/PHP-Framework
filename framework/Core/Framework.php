<?php

declare(strict_types=1);

namespace Eric\Core;

class Framework
{
    /**
     * @return void
     */
    public static function run()
    {
        self::_init();
        self::_autoload();
        self::_dispatch();
    }

    /**
     * @return void
     */
    private static function _init()
    {
        // Define path constants
        define("ROOT_PATH", getcwd() . DIRECTORY_SEPARATOR);
        define("APP_PATH", ROOT_PATH . "application" . DIRECTORY_SEPARATOR);
        define("FRAMEWORK_PATH", ROOT_PATH . "framework" . DIRECTORY_SEPARATOR);
        define("PUBLIC_PATH", ROOT_PATH . "public" . DIRECTORY_SEPARATOR);

        define("CONFIG_PATH", APP_PATH . "config" . DIRECTORY_SEPARATOR);
        define("CONTROLLER_PATH", APP_PATH . "controller" . DIRECTORY_SEPARATOR);
        define("MODEL_PATH", APP_PATH . "model" . DIRECTORY_SEPARATOR);
        define("VAR_PATH", APP_PATH . "var" . DIRECTORY_SEPARATOR);
        define("VIEW_PATH", APP_PATH . "view" . DIRECTORY_SEPARATOR);

        define("CORE_PATH", FRAMEWORK_PATH . "core" . DIRECTORY_SEPARATOR);
        define("DATABASE_PATH", FRAMEWORK_PATH . "database" . DIRECTORY_SEPARATOR);
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DIRECTORY_SEPARATOR);
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DIRECTORY_SEPARATOR);

        define("CSS_PATH", PUBLIC_PATH . "css" . DIRECTORY_SEPARATOR);
        define("IMAGE_PATH", PUBLIC_PATH . "images" . DIRECTORY_SEPARATOR);
        define("JS_PATH", PUBLIC_PATH . "js" . DIRECTORY_SEPARATOR);
        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DIRECTORY_SEPARATOR);

        // Log files
        define("SQL_LOG", VAR_PATH . "log" . DIRECTORY_SEPARATOR . "sql.log");

        // Load configuration file
        $GLOBALS['config'] = include CONFIG_PATH . "env.php";
    }

    /**
     * @return void
     */
    private static function _autoload()
    {
    }

    /**
     * @return void
     */
    private static function _dispatch()
    {
        Route::execute();
    }
}