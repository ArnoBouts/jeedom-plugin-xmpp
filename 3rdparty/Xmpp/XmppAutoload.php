<?php
/**
 *
 */

/**
 * PHPMailer SPL autoloader.
 * @param string $classname The name of the class to load
 */

function XmppAutoloadFromDir($dir, $classname) {

    $filename = dirname(__FILE__).$dir.$classname.'.php';
    if (is_readable($filename)) {
        require $filename;
        return true;
    }
    return false;
}

function XmppAutoload($classname)
{
    //Can't use __DIR__ as it's only in PHP 5.3+
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Connection'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Event'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'EventListener'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'EventListener'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'EventListener'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR.'Authentication'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Exception'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Exception'.DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Protocol'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Protocol'.DIRECTORY_SEPARATOR.'User'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Stream'.DIRECTORY_SEPARATOR, $classname)) return;
    if(XmppAutoloadFromDir(DIRECTORY_SEPARATOR.'Util'.DIRECTORY_SEPARATOR, $classname)) return;
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
