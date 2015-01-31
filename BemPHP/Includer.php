<?php
namespace BemPHP;

use BemPHP\LogWriter;
use BemPHP\Globals;
use BemPHP\BlocksStorage;

/** Загрузчик файлов, описывающих блоки
 * Class Includer
 * @package BemPHP
 */
class Includer {
    /**
     * Путь где лежат файлы блоков
     */
    const BLOCKS_PATH = Globals::BLOCK_PATH_DEFAULT;

    /** Пути к файлам *.php
     * @var array
     */
    protected static $_pathsToPHPFiles=array();

    /** список масок, для подключения блоков
     * @var array
     */
    protected static $_includeBlocksMasks=array();


    /** функция проверяет наличие файла в директории с имененем как у дирректории и с задоваемым форматом
     * @param string $path
     * @param string $fileFormat
     * @return bool|string
     */
    private function fileNameEqualDirName($path,$fileFormat='.php'){
        $dirName = substr(strrchr($path,'/'),1);
        foreach (glob($path.'/*'.$fileFormat) as $file) {
            $fileName = substr(strrchr($file,'/'),1,strlen(strrchr($file,'/'))-1-strlen($fileFormat));
            if (!Globals::LOAD_NOT_MATCH_FILES){
                if ($dirName == $fileName){
                    return $file;
                }
            }
            else return $file;
        }
        return false;
    }

    /** рекурсивный обход директорий
     * @param $path
     */
    private function loadBlocks($path){
        foreach (glob($path.'/*',GLOB_ONLYDIR) as $blockDir) {

            $folderName = substr(strrchr($blockDir,'/'),1);

            if ((substr($folderName,0,strlen(Globals::BLOCK_PREFIX))==Globals::BLOCK_PREFIX)
                and (self::equalBlockMaskList($folderName)))
            {

                $includePHPFile = self::fileNameEqualDirName($blockDir,'.php');

                if ($includePHPFile) self::$_pathsToPHPFiles[]=$includePHPFile;
                else {
                    $block = BlocksStorage::createBlock($folderName);
                    $block->setBlockDir($blockDir);

                    $css = self::fileNameEqualDirName($blockDir,'.css');
                    $js = self::fileNameEqualDirName($blockDir,'.js');
                    if ($css) $block->loadCSSFile($css);
                    else LogWriter::putLog('Для блока '.$folderName.' не найдет css-файл.',3);

                    if ($js) $block->loadJSFile($js);
                    else LogWriter::putLog('Для блока '.$folderName.' не найден js-файл.',2);

                }
                self::loadBlocks($blockDir);
            }
        }
    }


    /** добавляет лист в массив
     * @param $list
     * @param string $separator
     */
    private function putIncludeBlocksMasks($list,$separator=','){
        $arr = explode($separator,$list);
        foreach ($arr as $val){
            self::$_includeBlocksMasks[] = trim($val);
        }
    }


    /** сравнивает имя блока с листом масок
     * @param string $blockName
     * @return bool
     */
    private function equalBlockMaskList($blockName){
        foreach (self::$_includeBlocksMasks as $val){
            if ((strpos($val,Globals::BLOCK_PREFIX)!=='0') and (substr($val,0,1)!=Globals::LIKE_MASK_SEPARATOR)) $val=Globals::BLOCK_PREFIX.$val;
            if (Globals::like($blockName,$val,Globals::LIKE_MASK_SEPARATOR)) return true;
        }
        return false;
    }


    /**
     * подключает PHP-файлы
     */
    private function  includePHPFiles(){
        foreach (self::$_pathsToPHPFiles as $val){
            include_once ($val);
        }
    }


    /** загружает блоки согласно списку масок
     * @param  string $blocksList
     * @param string $separator
     */
    public static function IncludeBlocksList($blocksList,$separator=','){
        self::putIncludeBlocksMasks($blocksList,$separator);
        self::loadBlocks(__DIR__.'/'.self::BLOCKS_PATH);
        self::includePHPFiles();
    }


    /**
     * Конструктор закрыт
     */
    private function __construct()
    {
    }

    /**
     * Клонирование запрещено
     */
    private function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    private function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    private function __wakeup()
    {
    }
}