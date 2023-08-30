<?php

if (!defined('DS')) {
    /**
     * Use the DS to separate the directories in other defines
     */
    define('DS', "/");

    /**
     * Use the DS to separate the directories in other defines
     */
    define('DS_REVERSE', '\\');

    /**
     *
     */
    define('ROOT', dirname(__DIR__) . DS);

    /**
     *
     */
    define('URL', $_SERVER['REQUEST_SCHEME'] . ":" . DS . DS . $_SERVER['SERVER_NAME'] . DS);
}
