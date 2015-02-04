<?php

namespace BemPHP;

/**
 * Class Log
 * @package BemPHP
 */
Class Log {
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
