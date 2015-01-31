<?php

namespace BemPHP;

use BemPHP\Autoload;


/**
 * Class Log
 * @package BemPHP
 */
Class Log{
    private $_msg;
    private $_msgType;
    const INFO = '2';
    const WARN = '3';
    const ERROR = '4';

    public  function setMsg($msg){
        $this->_msg=$msg;
    }

    public  function setMsgType($msgType){
        $this->_msgType=$msgType;
    }

    public function getMsg(){
        return $this->_msg;
    }

    public function getMsgType(){
        return $this->_msgType;
    }
}



/** клас для записи логов
 * Class LogWriter
 * @package BemPHP
 */
class LogWriter {

    /**
     * @var LogStorage
     */
    static private $_logStorage;
    /**
     * @var LogServicesStorage
     */
    static private $_logServicesStorage;

    /** записывает лог в хранилище логов и производит оповещение лог сервисов.
     * @param string $msg
     * @param int $msgType
     */
    public static function putLog($msg,$msgType=1){
        $logStorage = self::getLogStorage();
        $logServiceStorage = self::getServicesStorage();

        //$logStorage->put(serialize(array('msg'=>$msg,'msgType'=>$msgType)));
        $log = new Log();
        $log->setMsg($msg);
        $log->setMsgType($msgType);

        $logStorage->put($log);
        $logServiceStorage->notifyServices($logStorage);

    }

    /** возвращает сылку на объект хранилища логов
     * @return LogStorage
     */
    public static function getLogStorage(){
        if (!isset(self::$_logStorage)) self::$_logStorage=new LogStorage();
        return self::$_logStorage;
    }


    /** возвращает ссылку на объект хранилища сервисов логирования
     * @return LogServicesStorage
     */
    public static function getServicesStorage(){
        if (!isset(self::$_logServicesStorage)) self::$_logServicesStorage=new LogServicesStorage();
        return self::$_logServicesStorage;
    }

};


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


/** интерфейс для оповещения сервисов логирования
 * Class Notifycator
 * @package BemPHP
 */
interface Notifycator{
    function notify($logStorage);
};


/** класс выводящий логи в косоль js
 * Class JsConsoleLogService
 * @package BemPHP
 */
class JsConsoleLogService implements Notifycator
{
    /**
     * @param LogStorage $logStorage
     */
    function notify($logStorage){
        $this->putInJsConsole($logStorage->getLastMsg(),$logStorage->getLastMsgType());
    }

    /** выводит сообщения в консоль js
     * @param string $msg
     * @param string $msgType
     */
    private function putInJsConsole($msg,$msgType){
        if ($msgType == Log::INFO) echo "<script type='text/javascript'>console.info('".$msg."')</script>";
        else if ($msgType == Log::WARN) echo "<script type='text/javascript'>console.warn('".$msg."')</script>";
        else if ($msgType == Log::ERROR) echo "<script type='text/javascript'>console.error('".$msg."')</script>";
        else echo "<script type='text/javascript'>console.log('".$msg."')</script>";
    }
}

/** отображает логи в окне
 * Class Logger
 * @package BemPHP
 */
class Logger implements Notifycator
{

    private $_content;
    private $_errorFlag;

    /**
     * @var Log
     */
    private $_log;

    /**
     * регистрация в хранилище подписчиков на логи
     */
    function __construct(){
        LogWriter::getServicesStorage()->registerLogService($this);
    }

    /**
     * @param LogStorage $logStorage
     */
    function notify($logStorage){
        $arr = $logStorage->getLogArray();
        $this->createContent($arr);
    }

    /**
     * @param array $arr
     */
    private function createContent($arr)
    {
        $this->_content='';

        foreach ($arr as $log) {
            switch ($log->getMsgType()){
                case Log::INFO: $msgType = ' b-logger__msg_info'; break;
                case Log::WARN: $msgType = ' b-logger__msg_warn'; break;
                case Log::ERROR: $msgType = ' b-logger__msg_error'; $this->_errorFlag=true; break;
                default: $msgType = null;
            }

            $this->_content=$this->_content.Tree::html('b-logger__msg'.$msgType)->setContent($log->getMsg());
        }

    }

    /**
     * @return string
     */
    public function getTree(){
        $block = Tree::html('b-logger');
        if ($this->_errorFlag) $block->setAttribute('style','border: 2px solid #CE0000;');
        return $block->addContent(
                    Tree::html('b-logger__button')->addContent(
                        Tree::html('b-logger__button__arrow_down')
                    )
                    .
                    Tree::html('b-logger__text-box')->addContent($this->_content)
                );
    }

    function __ToString(){
        $this->notify(LogWriter::getLogStorage());
        return (string) $this->getTree();
    }

    function getContent(){
        return $this->_content;
    }

}
