<?php

namespace BemPHP;

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

}
