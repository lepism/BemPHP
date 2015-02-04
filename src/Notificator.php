<?php

namespace BemPHP;

/** интерфейс для оповещения сервисов логирования
 * Class Notifycator
 * @package BemPHP
 */
interface Notifycator{
    function notify($logStorage);
};