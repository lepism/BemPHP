<?php
namespace BemPHP;

include_once 'Autoload.php';
include_once 'LogWriter.php';


//LogWriter::getServicesStorage()->registerLogService(new JsConsoleLogService());


/** Класс подключения основных компонентов
 * Class BemPHP
 * @package BemPHP
 */
class BemPHP {

    /**
     * Создает авторегистрацию
     */
    public static function register_autoload()
    {
        Autoload::register();
        spl_autoload_call('BemPHP\Tree');
        //spl_autoload_extensions(".php");
        //spl_autoload_register();
    }

    /**
     * Удаляет авторегистрацию
     */
    public static function unregister_autoload()
    {
        Autoload::unregister();
    }

    /** Возвращает CSS код всех инициализированных блоков.
     * @return string
     */
    public static function getCss(){
        $css='';

        foreach(BlocksStorage::getBlocksArray() as $block){
           $css=$css.$block->getCss();
        }

        return $css;
    }


    /** Возвращает JS код всех инициализированных блоков.
     * @return string
     */
    public static function getJs(){
        $js='';

        foreach(BlocksStorage::getBlocksArray() as $block){
            $js=$js.$block->getJs();
        }

        return $js;
    }

    /** Подключает PHP-файлы блоков.
     * @param string $blocksList
     * @param string $separator
     */
    public static function includeBlocksList($blocksList,$separator=','){
        Includer::IncludeBlocksList($blocksList,$separator);
    }

    public static function showLogger(){
        return new Logger();
    }

}

?>