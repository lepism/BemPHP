<?php
use BemPHP\BlocksStorage;

BlocksStorage::createBlock('b-logger__msg')
                ->setBlockDir(__DIR__)
                ->loadCSSFile()
                ->setTag('p')
;
?>