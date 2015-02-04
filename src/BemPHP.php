<?php

namespace BemPHP;

//LogWriter::getServicesStorage()->registerLogService(new JsConsoleLogService());

/** Класс подключения основных компонентов
 * Class BemPHP
 * @package BemPHP
 */
class BemPHP {

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