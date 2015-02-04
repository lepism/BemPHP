<?php

namespace BemPHP;

/** Содержит глобальные пееменные, константы и функции
 * Class Globals
 * @package BemPHP
 */
final Class Globals extends Config {

    private static $vars = array();

    /** задает глобальные переменные
     * @param string $key имя переменной
     * @param string $var значение переменной
     * @return bool
     */
    public static function set($key, $var) {

        if (isset(self::$vars[$key]) == true) {

            LogWriter::putLog('Попытка создания глобальной переменной ' . $key . ', которая уже существует.');

            return false;
        }

        self::$vars[$key] = $var;

        return true;

    }

    /** возвращает значение глобальной переменной
     * @param string $key
     * @return string|null
     */
    public static function get($key) {

        if (isset(self::$vars[$key]) == false) {
            LogWriter::putLog('Попытка вызова не существующей глобальной переменной: '.$key,3);
            return null;

        }

        return self::$vars[$key];

    }

    /** удаляет глобальную переменную
     * @param $key имя переменной
     * @return bool
     */
    public static function remove($key) {
        if (isset(self::$vars[$key]) == true){
            LogWriter::putLog('Попытка удалить не существующую глобальную переменную: '.$key,3);
        }
        else unset(self::$vars[$key]);

        return true;
    }

    /** возвращает true - если маска $needle находит совпадение в $haystack
     * @param string $haystack
     * @param string $needle
     * @param string $separator
     * @return bool
     */
    public static function like($haystack, $needle,$separator = '*'){
        if(!$haystack or !$needle) return false;
        $arr = explode($separator,$needle);
        $pos = 0;
        if ($arr[0] and strpos($haystack,$arr[0],$pos)) return false;
        foreach ($arr as $val) {
            if ($val){
                if (!is_numeric(strpos($haystack,$val,$pos))) {
                    return false;
                }
                $pos=strpos($haystack,$val,$pos)+strlen($val);
            }
        }
        if (array_pop($arr) and $pos!=strlen($haystack)) return false;
        return true;
    }

    /** удаяляет пробелы, знаки переноса строки и комментарии в CSS коде.
     * @param string $code
     * @return string
     */
    public static function compressCSSCode($code){
        /* удалить комментарии */
        $code = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $code);
        /* удалить табуляции, пробелы, символы новой строки и т.д. */
        $code = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $code);
        return $code;
    }

    /** функция проверки наличия класса в CSS коде
     * @param string $code
     * @param string $className
     * @return bool
     */
    public static function validateCSSCode($code,$className){
        if (is_numeric(strpos($code,'.'.$className))) {
            if (in_array(substr($code,strpos($code,'.'.$className)+strlen($className)+1,1),array('{',':',' ')))
                return true;
        }
        return false;
    }

    /** Возвращает true, если для данного тэга не нужен закрывающ тэг.
     * @param string $tag
     * @return bool
     */
    public static function isNoClosingTag($tag){
        foreach (self::$_noClosingTagArr as $noClTag) {
            if ($tag === $noClTag) return true;
        }
        return false;
    }

    /** Генератор html кода
     * @param TreeBuilder|Block $block
     * @return string
     */
    public static function htmlGenerator($block){
        $attributes = null;
        foreach($block->getAttributes() as $attr => $val){
            $attributes=$attributes.$attr."='".$val."' ";
        }

        $tag = $block->getTag() ? $block->getTag() : Globals::DEFAULT_BLOCK_TAG;

        $closeTag = ">".$block->getContent()."</".$tag.">";
        if (Globals::isNoClosingTag($tag)) {
            $closeTag = " />";
            if ($block->getContent() !='') LogWriter::putLog('Для тэга '.$tag.' не должно быть контента. (блок: '.$block->getName().')',3);
        }

        return $block->getLightStart()."<".$tag." class='".$block->getName()."' ".$attributes.$closeTag.$block->getLightEnd();
    }

    /* Конструктор закрыт
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