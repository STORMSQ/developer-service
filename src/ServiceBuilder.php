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
        $isModel = app_path().DIRECTORY_SEPARATOR.config('developer.model_subpath').DIRECTORY_SEPARATOR.$modelName.'.php';
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
        $path = explode(DIRECTORY_SEPARATOR,config("developer.model_subpath"));
        $location = (count($path)-1==null && config("developer.model_subpath")!=null)?(implode("\\",$path).'\\'):implode("\\",$path);

        $modelName = 'App\\'.$location.$modelName;
        $ModelFactory::bind($modelName);
        $model =  app('Model');  
        return $model;
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