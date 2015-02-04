<?php

namespace BemPHP;

/** хранилище сервисов логов
 * Class LogServicesStorage
 * @package BemPHP
 */
class LogServicesStorage
{
    private $_logServices=array();

    /** регистрация сервиса
     * @param Object $logService
     */
    function registerLogService($logService){
        $this->_logServices[]=$logService;
    }

    /** удаление сервиса
     * @param Object $logService
     */
    function unregistLogService($logService){
       foreach ($this->_logServices as $key => $val) {
           if ($val == $logService) unset($this->_logServices[$key]);
       }
    }

    /** уведомление сервисов
     * @param $logStorage
     */
    function notifyServices($logStorage){
        foreach ($this->_logServices as $val){
            $val->notify($logStorage);
        }
    }
}
