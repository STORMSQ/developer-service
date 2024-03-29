<?php

namespace STORMSQ\DeveloperService\Commands;

use Illuminate\Console\Command;

class GenerateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'developer:make:service {path} {--withDefault=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '建立一個邏輯Service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $path = explode(DIRECTORY_SEPARATOR,$this->argument('path'));
        if($path[count($path)-1]==null){
            array_pop($path);
        }
        if($path[0]==null){
            array_shift($path);
        }
        if(file_exists(app_path($this->argument('path').'.php'))){
            $this->error("檔案已經存在!");
            exit;
        }
        $model = $this->option('withDefault');
        //$modelLower = strtolower($model);
        $serviceName = $path[count($path)-1];
        $filepath = substr(implode(DIRECTORY_SEPARATOR,$path),0,strrpos(implode(DIRECTORY_SEPARATOR,$path),DIRECTORY_SEPARATOR));
        $namespace = rtrim('App\\'.str_replace("/","\\",$filepath),"\\");
       
        if(!is_dir(app_path($filepath))){
            mkdir(app_path($filepath),0755,true);
        }
        $this->createService(['namespace'=>$namespace,'serviceName'=>$serviceName,'filepath'=>$filepath,'model'=>$model],(($model!=null)?true:false));  

        $this->info("Service 已成功建立!");

        
    }
    protected function getStub()
    {
        return file_get_contents(__DIR__.'/../../resources/stubs'.DIRECTORY_SEPARATOR."Service.stub");
    }
    protected function getStubWithDefault()
    {
        return file_get_contents(__DIR__.'/../../resources/stubs'.DIRECTORY_SEPARATOR."ServiceWithDefault.stub");
    }
    protected function createService(array $fillData,bool $withDefault)
    {
        $modelTemplate = str_replace(
            ['{{namespace}}','{{servicename}}','{{model}}','{{modellower}}'],
            [$fillData['namespace'],$fillData['serviceName'],$fillData['model'],strtolower($fillData['model'])],
            (($withDefault)?$this->getStubWithDefault():$this->getStub())
        );

        file_put_contents(app_path($fillData['filepath'].DIRECTORY_SEPARATOR.$fillData['serviceName'].".php"), $modelTemplate);
    }

    

}
