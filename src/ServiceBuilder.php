<?php
namespace STORMSQ\Developer;
use STORMSQ\Developer\Factory\ModelFactory;
//use Schema;
class ServiceBuilder{

    
    /**
     * 綁定Model
     *
     * @param string $modelName 模型名稱
     * @return void 如果存在Model，返回Model實例，否則返回空
     */
    public function getModel($modelName='')
    {
        $isModel = $this->isModel($modelName);
        if($isModel){
            $model = $this->modelSetting($modelName);
            return $model;
        }else{
            return null;
        }
    }
    /**
     * 私用方法，處理getModel中判斷是否為Model
     *
     * @param string $modelName 模型名稱
     * @return boolean
     */
    private function isModel($modelName)
    {
        $path = (config('developer.model.placepath'))?($this->checkRightPath(config('developer.model.placepath')).DIRECTORY_SEPARATOR):null; 
        $isModel = app_path().DIRECTORY_SEPARATOR.$path.$modelName.'.php';
        if(!file_exists($isModel)){
           return false;
        }else{
            return true;
        }
    }
    /**
     * 私用方法，綁定Model
     *
     * @param string $modelName 模型名稱
     * @return void 
     */
    private function modelSetting($modelName)
    {
        $ModelFactory = new ModelFactory;
        $config = $this->checkRightPath(config("developer.model.placepath"));
        
        $path = implode("\\",explode(DIRECTORY_SEPARATOR,$config));

        $modelName = 'App\\'.(($path)?$path."\\":null).$modelName;
        $ModelFactory::bind($modelName);
        $model =  app('Model');  
        return $model;
    } 

    private function checkRightPath($string,$sign="/")
    {      
        return (strrpos($string,$sign)==strlen($string)-1)?$this->checkRightPath(substr($string,0,strlen($string)-1)):$string;
    }
	/**
	 * 檢查模型是否有該欄位
	 *
	 * @param [type] $model 模型名稱
	 * @param [type] $columnName 欄位名稱
	 * @return boolean 是/否
	 */
    /*public static function hasColumn($model,$columnName)
    {
        return Schema::hasColumn($model->getTable(), $columnName);
    }*/
}