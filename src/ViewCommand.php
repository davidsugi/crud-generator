<?php

namespace  Luxodev\Mvc;

use Illuminate\Console\Command;
use File;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ViewCommand extends Command
{
    protected $signature = 'generate {name} {--a|all} {--f|factory} {--c|controller} {--m|model} {--i|view} {--r|route} {--s|noshow} {--o|noform} {--d|withdetail}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create fully complete MVC';

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
        $bar = $this->output->createProgressBar(5);
        $arr=[];
        $name = $this->argument('name');

        if ($this->option('all')) {
            $this->input->setOption('model', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('view', true);
            $this->input->setOption('route', true);
        }
      
        if ($this->option('factory')) {
            $this->createFactory();
        }

        if ($this->option('model')) {
            $arr=$this->createMigration($name);
            $bar->advance();
        }

        if ($this->option('controller')) {
            $this->input->setOption('route', true);
            $this->createController($name);
            $bar->advance();
        }

        if ($this->option('view')) {
            $this->createView($name);
            $bar->advance();
        }

        if ($this->option('route')) {
            File::append(base_path('routes/web.php'),
                "
Route::resource('" . str_plural(strtolower($name)) . "', '{$name}Controller');");
            File::append(base_path('routes/api.php'),
                "
Route::post('" . str_plural(strtolower($name)) . "/create', '{$name}Controller@api_create');
Route::post('" . str_plural(strtolower($name)) . "/show', '{$name}Controller@api_show');
Route::post('" . str_plural(strtolower($name)) . "/update/{id}', '{$name}Controller@api_update');
Route::delete('" . str_plural(strtolower($name)) . "/delete/{id}', '{$name}Controller@api_delete');");  
        }
        if (file_exists(resource_path('views/layouts/_sidebar_menu.blade.php'))){
            $filename = resource_path('views/layouts/_sidebar_menu.blade.php'); // the file to change
            $search = '<!-- sidebar menu: add more below -->'; // the content after which you want to insert new stuff
            $insert = '      <li class="{{active(\''.str_plural(strtolower($name)).'\')}}"><a href="{{ route("'.str_plural(strtolower($name)).'.index") }}" ><i class="fa fa-star"></i><span>'.$name.'</span></a></li>'; // your new stuff

            $replace = $search. "\n". $insert;

            file_put_contents($filename, str_replace($search, $replace, file_get_contents($filename)));
            $bar->advance();
        }        
        // $this->call('make:model',['name'=>$view,'--migration'=>'','--controller'=>'']);
        $bar->finish();
        $this->info('MVC of '.$name.' Generated Successfully');

    }

    protected function getStub($type){
        return file_get_contents(__DIR__.'/stubs/'.$type.'.stub');
    }

     /**
     * Get the view full path.
     *
     * @param string $view
     *
     * @return string
     */
    public function viewPath($view)
    {
        $view = str_replace('.', '/', $view) . '.blade.php';

        $path = "resources/views/{$view}";

        return $path;
    }

    /**
     * Create view directory if not exists.
     *
     * @param $path
     */
    public function createDir($path)
    {
        $dir = dirname($path);

        if (!file_exists($dir))
        {
            mkdir($dir, 0777, true);
        }
    }

    protected function createView($name)
    {

        $view = $this->argument('name');
        $kind = ['index'];
        if(!$this->option('noform'))
            $kind[]='_form';
        if(!$this->option('noshow'))
            $kind[]='show';

        foreach($kind as $kin){
            $path = $this->viewPath(strtolower($name)."/".$kin);
            $this->createDir($path);
            if (File::exists($path))
            {
                $this->error("File {$path} already exists!");
                // return;
            }

            $controllerTemplate = str_replace([
            '{{modelName}}',
            '{{modelNamePlural}}',
            '{{modelNameSingular}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub($kin));
                file_put_contents(resource_path("/views/{$name}/".$kin.".blade.php"), $controllerTemplate);
        }

        $this->info("View {$view} created.");

        
        // $factory = Str::studly(class_basename($this->argument('name')));

        // $this->call('make:factory', [
        //     'name' => "{$factory}Factory",
        //     '--model' => $this->argument('name'),
        // ]);
    }

    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->argument('name'),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration($name)
    {
            $arr=[];
        if ($this->confirm('Create Migration Schema?')) {
            $mig = $this->ask('enter migration table');
            $headers = ['Option','Column', 'Type'];
            $type = array('str'=>'string','int'=>'integer','fk'=>'unsignedInteger:foreign','txt'=>'text','dt'=>'date','ts'=>'timestamp');
            $opt = array('null'=>'nullable','uq'=>'unique','def'=>'default(0)');
            $result= explode(';',$mig);
            $str="";
            foreach($result as $op){
                $res= explode(':',$op);
                $tmp=[];
                $tmp[2]="";
                
                foreach($res as $i=>$r){
                    if($i==0){
                        $tmp[]=$r;
                        $str.=$r;
                    }
                    elseif($i==1){
                        $tmp[]=$type[$r];
                        $str.=":".$type[$r];
                    }
                    else{
                        if(strpos($r,"default")>=0){
                            $tmp[2].=$r.",";
                            $str.=":".$r;
                        }
                        else{
                            $tmp[2].=$opt[$r].",";
                            $str.=":".$opt[$r];
                        }
                    }
                }
                $str.=", ";
                $tmp[2]=rtrim($tmp[2], ',');
                $arr[]=$tmp;
               
            }
                $str=rtrim($str, ', ');

            $this->table($headers, $arr);
            $this->info($str);
            $table = Str::plural(Str::snake(class_basename($name)));

             $this->call('make:migration:schema', [
                'name' => "create_{$table}_table",
                '--schema' => $str,
            ]);
            return $arr;

            // $bar->advance();
        }
        else{
                if($this->option('withdetail')){
                $modelTemplate = str_replace(
                    ['{{modelName}}', '{{modelNamePlural}}','{{modelNameSingular}}'],
                    [$name, strtolower(str_plural($name)),strtolower($name)],
                    $this->getStub('Model')
                );
                file_put_contents(app_path("/{$name}.php"), $modelTemplate);

                $modelTemplate = str_replace(
                    ['{{modelName}}', '{{modelNamePlural}}','{{modelNameSingular}}'],
                    [$name, strtolower(str_plural($name)),strtolower($name)],
                    $this->getStub('ModelWD')
                );
                file_put_contents(app_path("/Detail{$name}.php"), $modelTemplate);

                $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

                $this->call('make:migration', [
                    'name' => "create_{$table}_table",
                    '--create' => $table,
                ]);
                $this->call('make:migration', [
                    'name' => "create_detail_{$table}_table",
                    '--create' => $table,
                ]);
            }
            else{
                $this->call('make:model', [
                    'name' => $this->argument('name')
                ]);

                $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

                $this->call('make:migration', [
                    'name' => "create_{$table}_table",
                    '--create' => $table,
                ]);
            }

            return $arr;
        }
       
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController($name)
    {
        $type="Controller";
        if($this->option('withdetail')){
            $type="ControllerWD";
        }
         $controllerTemplate = str_replace([
        '{{modelName}}',
        '{{modelNamePlural}}',
        '{{modelNameSingular}}'
        ],
        [
            $name,
            strtolower(str_plural($name)),
            strtolower($name)
        ],
        $this->getStub($type));
        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }
    
}
