<?php
use BemPHP\Block;
use BemPHP\Tree;

$_blockName_= 'b-logger__button__arrow_down'; /* обязательно указать имя блока (оно должно быть уникальным) */
$logger__button = new Block($_blockName_);
$logger__button->setBlockDir(__DIR__) /*обязательно указать директорию блока, иначе подключение файлов может работать не корректно*/
    ->loadCSSFile($_blockName_.'.css')
;

?>