<?php
use BemPHP\Block;

$_blockName_ = 'b-logger__text-box'; /* обязательно указать имя блока (оно должно быть уникальным) */
$_blockObj_ = new Block($_blockName_);
$_blockObj_->setBlockDir(__DIR__) /*обязательно указать директорию блока, иначе подключение файлов может работать не корректно*/
    ->loadCSSFile($_blockName_.'.css') /* загружаем данные из css файла (если отправить null, то будет происходить поиск файла $_blockName_.'.css') */
;
?>