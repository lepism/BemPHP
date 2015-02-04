<?php

namespace BemPHP;

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
