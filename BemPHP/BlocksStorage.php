<?php


namespace BemPHP;

/**
 * Class BlocksStorage Предназначен для хранения ссылок на объекты блоков.
 * @package BemPHP
 */

final class BlocksStorage {
    static private $_blocks = array();


    /** Добавляет блок в общее хранилище
     * @param Block $block
     */
    public static function setBlock(Block $block){
        if (array_key_exists($block->getName(),self::$_blocks)){
            LogWriter::putLog('Блок с именем '.$block->getName().' уже существует.',4);
        }
        else {
            self::$_blocks[$block->getName()]=$block;
            LogWriter::putLog('Добавлен блок '.$block->getName(),2);
        }
    }

    /** возвращает ссылку на объект блока
     * @param string $blockName
     * @return Block
     */
    public static  function getBlock($blockName){
        if (isset(self::$_blocks[$blockName])) {
            return self::$_blocks[$blockName];
        }
        else {
            LogWriter::putLog('Блок '.$blockName.' не инициализирован.',4);
            return null;
        }
    }

    /** Удаляет блок из хранилища
     * @param $blockName
     */
    public static function removeBlock($blockName)
    {
        if (array_key_exists($blockName, self::$_blocks)) {
            unset(self::$_blocks[$blockName]);
        }
    }

    /** Создание нового блока
     * @param $blockName
     * @return Block
     */
    public static function createBlock($blockName){
        return new Block($blockName);
    }

    /** Возвращает массив объектов.
     * @return array
     */
    public static function getBlocksArray(){
        return self::$_blocks;
    }

    /**
     * Конструктор закрыт
     */
    private function __construct()
    {
    }

    /**
     * Клонирование запрещено
     */
    private function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    private function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    private function __wakeup()
    {
    }

}