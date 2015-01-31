<?php

namespace BemPHP;
use BemPHP\LogWriter;
use BemPHP\BlocksStorage;
use BemPHP\BlockBase;

/** Класс для описания блока
 * Class Block
 * @package BemPHP
 */
class Block extends BlockBase {

    protected $_blockDir;
    protected $_css = '';
    protected $_js = '';


    /**
     * @param string $name
     */
    function __construct($name){
        $name=trim($name);
        if (strpos($name,' ')) {
            LogWriter::putLog('В имени блока не может быть пробела! ('.$name.')',4);
            return null;
        }
        $this->_blockName = $name;
        BlocksStorage::setBlock($this);
    }



/*================= BLOCK DIR ==================*/

    /**
     * задает папку, где лежат файлы блока
     * @param string $path
     * @return $Block
     */
    public function setBlockDir($path){
        $this->_blockDir = $path;
        return $this;
    }

    /** возвращает путь к папке блока
     * @return string
     */
    public function getBlockDir(){
        return $this->_blockDir;
    }

    /** Получает имя файла и его расширение, возвращает путь к файлу
     * @param string $fileName
     * @param string $fileType
     * @return string
     */
    private function getFilePath($fileName,$fileType='.css'){

        if (!$fileName) $fileName=$this->_blockName;

        if (substr($fileName,strlen($fileName)-strlen($fileType),strlen($fileType))!=$fileType) $fileName=$fileName.$fileType;

        $fileName=str_replace($this->_blockDir,'',$fileName);

        return $this->_blockDir.'/'.$fileName;
    }

/*================= CSS ==================*/

    /** добавляет в таблицу стиля блока правило, так же можно задать псевдо класс (например hover)
     * @param string $cssCode
     * @param string|null $pseudoClass
     * @return Block
     */

    public function addCssRule($cssCode,$pseudoClass=null){
        if ($pseudoClass != null) $pseudoClass=':'.$pseudoClass;
        $this->_css=$this->_css.'.'.$this->_blockName.$pseudoClass.'{'.Globals::compressCSSCode($cssCode).'}';

        return $this;
    }

    /** Загружает данные из файла в переменную _css
     * @param string|null $fileName задает имя файла
     * @return Block
     */
    public function loadCSSFile($fileName=null){

        $fileName = self::getFilePath($fileName,'.css');

        if (file_exists($fileName)) {

                $fileCSS = Globals::compressCSSCode(file_get_contents($fileName));

                if (!Globals::validateCSSCode($fileCSS,$this->_blockName)) LogWriter::putLog('В файле '.$fileName.' не найдено описание класса '.$this->_blockName.'.',4);

                $this->_css=$this->_css.' '.$fileCSS;
        }
        else LogWriter::putLog('Не найден css-файл: '.$fileName,4);


        return $this;
    }

    /** возвращает строку css блока
     * @return string
     */
    public function getCss(){
        return $this->_css;
    }

/*================= JAVASCRIPT ==================*/

    /** Загружает данные из файла в переменную _js
     * @param string|null $fileName
     * @return Block
     */

    public function loadJSFile($fileName=null){

        $fileName = self::getFilePath($fileName,'.js');

        if (file_exists($fileName)) {
            $fileJs = Globals::compressCSSCode(file_get_contents($fileName));

            $this->_js=$this->_js.' '.$fileJs;
        }
        else LogWriter::putLog('Не найден js-файл: '.$fileName,4);

        return $this;
    }

    /** возвращает строку js блока
     * @return string
     */
    public function getJs(){
        return $this->_js;
    }

}


?>
