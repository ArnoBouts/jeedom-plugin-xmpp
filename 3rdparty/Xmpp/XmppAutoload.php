<?php
/**
 *
 */

/**
 * XmppAutoload SPL autoloader.
 * @param string $classname The name of the class to load
 */

function XmppAutoload($classname)
{
    $dirs = array('',
            'Connection'.DIRECTORY_SEPARATOR,
            'Event'.DIRECTORY_SEPARATOR,
            'EventListener'.DIRECTORY_SEPARATOR,
            'EventListener'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR,
            'EventListener'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR.'Authentication'.DIRECTORY_SEPARATOR,
            'Exception'.DIRECTORY_SEPARATOR,
            'Exception'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR,
            'Protocol'.DIRECTORY_SEPARATOR,
            'Protocol'.DIRECTORY_SEPARATOR.'User'.DIRECTORY_SEPARATOR,
            'Stream'.DIRECTORY_SEPARATOR,
            'Util'.DIRECTORY_SEPARATOR);

    foreach ($dirs as $dir) {
        $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.$dir.$classname.'.php';
        if (is_readable($filename)) {
            require $filename;
            break;
        }
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('XmppAutoload', true, true);
    } else {
        spl_autoload_register('XmppAutoload');
    }
} else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
        XmppAutoload($classname);
    }
}
