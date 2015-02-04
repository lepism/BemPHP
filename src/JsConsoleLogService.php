<?php

namespace BemPHP;

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