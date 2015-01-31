<?php
use BemPHP\Block;
use BemPHP\Tree;

$_blockName_= 'b-logger__button'; /* обязательно указать имя блока (оно должно быть уникальным) */
$logger__button = new Block($_blockName_);
$logger__button->setBlockDir(__DIR__) /*обязательно указать директорию блока, иначе подключение файлов может работать не корректно*/
           ->loadCSSFile($_blockName_.'.css') /* загружаем данные из css файла (если отправить null, то будет происходить поиск файла $_blockName_.'.css') */
           ->loadJSFile()
           //->addContent('<div style="position: absolute; left: 150px;">&#9660;</div>') /* &#9650;  */
;