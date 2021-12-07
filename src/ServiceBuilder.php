<?php
namespace STORMSQ\Developer;
use STORMSQ\Developer\Factory\ModelFactory;
use Schema;
class ServiceBuilder{

    
    /**
	 * 創建一個空的請求
	 *
	 * @param array $data 參數陣列
	 * @return request 返回一個request實例
	 */
	public function getEmptyRequest(array $data=[])
	{
		$request = Request::capture();
        
        foreach($request->all() as $key=>$row){
            $request->request->remove($key);
        }
		$array = [];
		foreach($data as $key=>$row){
			$array[$key]=  $row;
		}
		$request->request->add($array);
		return $request;
    }
    /**
     * 分頁處理
     *
     * @param  $builder 查詢語句
     * @param  int $num 一頁幾筆
     * @param  boolean $usePaginate
     * @return void
     */
    protected function resultSet($builder,$num=10,$usePaginate=true)
    {
        return ($usePaginate)?$builder->paginate($num):$builder->get();
    }
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
	 * 檢查模型是否有該欄位
	 *
	 * @param [type] $model 模型名稱
	 * @param [type] $columnName 欄位名稱
	 * @return boolean 是/否
	 */
    public function hasColumn($model,$columnName)
    {
        return Schema::hasColumn($model->getTable(), $columnName);
    }

    /**
     * 私用方法，處理getModel中判斷是否為Model
     *
     * @param string $modelName 模型名稱
     * @return boolean
     */
    private function isModel($modelName)
    {
        $path = (config('developer.model.placepath'))?($this->removeSpecificFlag(config('developer.model.placepath')).DIRECTORY_SEPARATOR):null; 
        $isModel = app_path().DIRECTORY_SEPARATOR.$this->removeSpecificFlag($path,false).$modelName.'.php';
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
        $config = $this->removeSpecificFlag($this->removeSpecificFlag(config("developer.model.placepath")),false);
        
        $path = implode("\\",explode(DIRECTORY_SEPARATOR,$config));

        $modelName = 'App\\'.(($path)?$path."\\":null).$modelName;
        $ModelFactory::bind($modelName);
        $model =  app('Model');  
        return $model;
    } 

    /**
     * 私有方法，將特定路徑轉換成反斜線"\"
     *
     * @param [type] $string 路徑
     * @param boolean $fromRight 是否從右邊開始
     * @param string $sign 路徑標誌，預設是/ 
     * @return string 轉換後的路徑
     */
    private function removeSpecificFlag($string,$fromRight=true,$sign="/")
    {      
        if($fromRight){
             return (strrpos($string,$sign)==strlen($string)-1)?$this->removeSpecificFlag(substr($string,0,strlen($string)-1)):$string;
        }else{
            return (stripos($string,$sign)===0)?$this->removeSpecificFlag(substr($string,1,strlen($string)),false):$string;
        }
    }

}