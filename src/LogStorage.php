<?php

namespace BemPHP;

/** Хранилище логов
 * Class LogStorage
 * @package BemPHP
 */
class LogStorage {
    protected $_logArray=array();

    /**
     * @var Log
     */
    protected $_lastLog;

    /** добавляет лог
     * @param Log $log
     */
    function put($log){
        $this->_logArray[]=$log;
        $this->_lastLog = $log;
    }

    /** возвращает массив всех логов
     * @return array
     */
    function getLogArray(){
        return $this->_logArray;
    }

    /**
     * @return Log
     */
    function getLastLog(){
        return $this->_lastLog;
    }

    /** возвращает последний текст лога
     * @return string
     */
    function getLastMsg(){
        return $this->_lastLog->getMsg();
    }

    /** возвращает тип последнего лога.
     * @return string
     */
    function getLastMsgType(){
        return $this->_lastLog->getMsgType();
    }
}