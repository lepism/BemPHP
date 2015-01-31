<?php

namespace BemPHP;

/** Базовый класс для описания блока
 * Class BlockBase
 * @package BemPHP
 */
class BlockBase {
    /** Тэг
     * @var null
     */
    protected $_tag = null;
    /** Аттрибуты
     * @var array
     */
    protected $_attributes = array();
    /** Контент
     * @var string
     */
    protected $_content=null;
    /** Имя блока
     * @var string
     */
    protected $_blockName;

    private $_lightStart = null;
    private $_lightEnd = null;


    /** Возвращает имя Блока
     * @return string
     */
    public function getName(){
        return $this->_blockName;
    }

    /** Возвращает http код блока.
     * @return string
     */
    function __ToString(){
        return Globals::htmlGenerator($this); //$this->htmlBlockParser();
    }

/*================= ATTRIBUTES ==================*/

    /** задает аттрибуты тэга
     * @param string $attr имя аттрибута
     * @param string $val значение
     * @return $this
     */
    public function setAttribute($attr,$val){
        if (array_key_exists($attr,$this->_attributes)) LogWriter::putLog('Атрибут '.$attr.' в блоке '.$this->_blockName.' перезаписан на значение '.$val.'.',1);
        $this->_attributes[$attr]=$val;

        return $this;
    }


    /** удаляет заданый атрибут
     * @param string $attr
     * @return $this
     */
    public function removeAttribute($attr){
        if (array_key_exists($attr,$this->_attributes)){
            unset($this->_attributes[$attr]);
        }
        else {
            LogWriter::putLog('Попытка удалить не существующий аттрибут '.$attr.' блока '.$this->_blockName.'.',3);
        }

        return $this;
    }

    /** очистка всех тарибутов
     * @return $this
     */
    public function clearAttributes(){
        $this->_attributes=array();

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(){
        return $this->_attributes;
    }
/*================= TAG ==================*/

    /** задает тэг блока
     * @param string $tag
     * @return $this
     */
    public function setTag($tag){
        $this->_tag= strtolower($tag);
        return $this;
    }


    /** возвращает значение tag
     * @return string|null
     */
    public function getTag(){
        return $this->_tag;
    }

/*================= CONTENT ==================*/


    /** Вставляет контент, перезатирая старый
     * @param string $content
     * @return $this
     */
    public function setContent($content){
        $this->_content=$content;

        return $this;
    }

    /** добавляет контент для блока
     * @param string $content контент
     * @param bool $inTheBeginningOfTheLine флаг, если true - то добавляет контент в начало строки, иначе в конец.
     * @return $this
     */
    public function addContent($content,$inTheBeginningOfTheLine=false){
        if(!$this->_content) $this->_content='';

        $this->_content=$inTheBeginningOfTheLine ? $content.$this->_content : $this->_content.$content;

        return $this;
    }

    /** Возвращает контент
     * @return string
     */
    public function getContent(){
        return $this->_content;
    }
/*================= LIGHTING ==================*/

    /** Подсветка кода
     * @return TreeBuilder
     */
    public function lighting(){
        $this->_lightStart = "\n \n\n<!-- == BLOCK $this->_blockName HERE!!! == --!>\n \n";
        $this->_lightEnd = "\n \n<!-- ========= END ========= --!>\n \n\n";
        return $this;
    }

    public function getLightStart(){
        return $this->_lightStart;
    }

    public function getLightEnd(){
        return $this->_lightEnd;
    }

}