<?php
namespace BemPHP;
use BemPHP\LogWriter;

/** Класс создающий автозагрузку
 * Class Autoload
 * @package BemPHP
 */
class Autoload
{
    const NAMESPACE_SEPARATOR = '\\';

    /** @var Корневой путь приложения */
    private static $_include_path;
    /** @var Флаг регистрации функции автозагрузки */
    private static $_flag_register;
    /** @var Корневое пространство имен */
    private static $_root_ns;


    /** Регистрация функции автозагрузки */
    public static function register()
    {
        if (phpversion()<'5.1.2') {
            echo "BemPHP не может работать с версией PHP ниже 5.1.2"; return;
        }
        elseif (phpversion()>='5.3') {
            spl_autoload_extensions(".php");
            set_include_path(dirname(__DIR__));
            spl_autoload_register();
        }
        else {
            if (self::$_flag_register) return;

            self::$_root_ns 		= __NAMESPACE__;
            self::$_include_path 	= dirname(__DIR__);

            spl_autoload_register(array(__CLASS__, 'autoload'), false, true);

            self::$_flag_register = true;

            LogWriter::putLog('Register ok. Include_path: '.self::$_include_path.'; root_ns: '.self::$_root_ns);
        }
    }


    /** Удаление следов регистрации функции автозагрузки */
    public static function unregister()
    {
        if (self::$_flag_register !== true) return;

        self::$_root_ns			= null;
        self::$_include_path 	= null;

        spl_autoload_unregister(array(__CLASS__, 'autoload'));

        self::$_flag_register = false;
    }


    /**
     * Функция автозагрузки, вызываыется после регистрации каждый раз когда обнаруживается неизвестный класс
     * @param $class_name
     */
    public static function autoload($class_name)
    {
        LogWriter::putLog('run autoload => '.$class_name);
        // Защита от запуска не для нашего пространства имен
        if (strstr($class_name, self::NAMESPACE_SEPARATOR, true) !== self::$_root_ns) return;


        $path =
            self::$_include_path.\DIRECTORY_SEPARATOR.
                str_replace(self::NAMESPACE_SEPARATOR, \DIRECTORY_SEPARATOR, $class_name).
                '.php';

        LogWriter::putLog('include path: '.$path);

        if (file_exists($path))
        {
            include_once $path;
            LogWriter::putLog('include ok');
        }
        else {LogWriter::putLog('include file not found!',4);}
    }
}