<?php

namespace BemPHP;

/** Конфигурационный класс
 * Class Config
 * @package BemPHP
 */
class Config {

    /**
     * Дефолтный тэг для блока
     */
    const DEFAULT_BLOCK_TAG = 'div';

    /**
     * Константа включающая или отключающая загрузку CSS
     */
    const LOAD_CSS_ENABLED = true;

    /**
     * Константа включающая или отключающая загрузку JavaScript
     */
    const LOAD_JS_ENABLED = true;

    /**
     * папка где хранятся блоки
     */
    const BLOCK_PATH_DEFAULT='blocks';

    /**
     * префикс, указывающий что папка является папкой блока
     */
    const BLOCK_PREFIX = 'b-';

    /**
     * если false - то из папки с блоком будут грузиться тольк те файлы, что совпадают с именем папки, если true - то все
     */
    const LOAD_NOT_MATCH_FILES = false;

    /**
     * разделитель для маски сравнения
     */
    const LIKE_MASK_SEPARATOR = '*';

    /** тэги у которых нет закрвыющих тэгов
     * @var array
     */
    protected  static $_noClosingTagArr = array('area','base','basefont','br','col','frame','hr','img','input','isindex','link','meta','param');

/* ======================================================== */

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