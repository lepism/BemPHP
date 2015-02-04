<?php

namespace BemPHP;

use BemPHP\BlockBase;

/** Класс создания ветви БЭМ-дерева.
 * Class TreeBuilder
 * @package BemPHP
 */
class TreeBuilder extends BlockBase
{
    /**
     * @var Block
     */
    protected $_currentBlock;


    /** Конструктор присваивает значения из объекта блока в объект TreeBuilder
     * @param string $block
     */
    function __construct($blockName){

        $this->_blockName = $blockName;

        $this->constructTreeBuilder();
    }

    /**
     * Функция получения значений из Блоков
     */
    private function constructTreeBuilder(){
        $arr = explode(' ',$this->_blockName);

        foreach ($arr as $val){

            if (BlocksStorage::getBlock($val)) $this->_currentBlock=BlocksStorage::getBlock($val);
            else break;

            if ($this->_currentBlock->getTag()) $this->_tag = $this->_currentBlock->getTag();

            $this->_attributes = $this->_currentBlock->getAttributes() + $this->_attributes;

            if ($this->_currentBlock->getContent()!==null) $this->_content=$this->_currentBlock->getContent();
        }
    }

    /** функция возврата к изначальному блоку
     * @return TreeBuilder
     */
    public function getDefault(){

        $this->constructTreeBuilder();

        return $this;
    }

}

/** Класс инициализирующий ветвь БЭМ-дерева
 * Class Tree
 * @package BemPHP
 */
class Tree {
    /**
     * @param $blockName
     * @return TreeBuilder
     */
    public static function html($blockName){
        return new TreeBuilder($blockName);
    }

}