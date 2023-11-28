<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 *
 */
class MakeCustomModule extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:custom-module {moduleName}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Module with repository design pattern';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call("module:make {$this->getModuleName()}");
        Artisan::call("module:make-request Create{$this->getModuleName()}Request {$this->getModuleName()}");
        Artisan::call("module:make-request Update{$this->getModuleName()}Request {$this->getModuleName()}");
        Artisan::call("make:entity {$this->getModuleName()} -n");

        $this->setModuleGeneratorConfig();
        $this->publishRepositoryServiceProvider();
        $this->publishModel();
        $this->moveMigrationFile();
        $this->publishRepositoriesDir();
        $this->publishRequestCriteria();
        $this->publishBaseServices();
        $this->publishTraits();
        $this->publishEnums();

        match ($this->choice("What do you want for data presentation?", ['presenter','resource'])){
            'resource'=> $this->publishResource($this->confirm('Do you want Collection Resource?')),
            default => $this->publishPresenter($this->confirm('Do you want Transformer?')),
        };
    }


    /**
     * @return void
     */
    public function setModuleGeneratorConfig()
    {
        Config::set([
            "modules.paths.generator.model" => ["path" => "Models", "generate" => true],
            "modules.paths.generator.resource" => ["path" => "Transformers", "generate" => true],
            "repository.generator.basePath" => $this->getModulePath(),
            "repository.generator.rootNamespace"  => "{$this->getModuleNameSpace()}\\",
            "repository.generator.stubsOverridePath" => $this->getModulePath(),
            "repository.generator.paths.models" => "Models",
            "repository.generator.paths.repositories" => "Repositories",
            "repository.generator.paths.interfaces" => "Repositories",
            "repository.generator.paths.transformers" => "Transformers",
            "repository.generator.paths.presenters" => "Presenters",
            "repository.generator.paths.validators" => "Validators",
            "repository.generator.paths.controllers" => "Http/Controllers",
            "repository.generator.paths.provider" => "RepositoryServiceProvider",
            "repository.generator.paths.criteria" => "Criteria",
        ]);
    }


    /**
     * @return void
     */
    public function publishRepositoryServiceProvider()
    {
        $moduleProvidersPath = "{$this->getModulePath()}/Providers";
        $this->files->move(app_path("Providers/RepositoryServiceProvider.php"), $moduleRepositoryServiceProviderPath = "$moduleProvidersPath/RepositoryServiceProvider.php");
        $this->updateNameSpace($moduleRepositoryServiceProviderPath);
        $this->files->replaceInFile(
            '$this->app->register(RouteServiceProvider::class);',
            '$this->app->register(RouteServiceProvider::class);'
            ."{$this->delimiter()}{$this->delimiter(char: ' ',count: 8)}".'$this->app->register(RepositoryServiceProvider::class);',
            "$moduleProvidersPath/{$this->getModuleName()}ServiceProvider.php"
        );
    }


    /**
     * @return void
     */
    public function publishRepositoriesDir()
    {
        $this->files->move(app_path("Repositories"), $repositoriesPath = "{$this->getModulePath()}/Repositories");
        $this->getDirFiles($repositoriesPath)->each(function($fileName) use ($repositoriesPath) {
            $this->updateNameSpace($filePath = "$repositoriesPath/$fileName");
            Str::contains($fileName, "Eloquent") and $this->files->replaceInFile(
                "use ".RequestCriteria::class,
                "use {$this->getModuleNameSpace()}\\Criteria\\RequestCriteria",
                $filePath
            );
        });
    }


    /**
     * @return void
     */
    public function publishModel()
    {
        $this->files->move(app_path("Models/{$this->getModuleName()}.php"), $modelPath = "{$this->getModulePath()}/Models/{$this->getModuleName()}.php");
        $this->updateNameSpace($modelPath);
    }


    /**
     * @return void
     */
    protected function moveMigrationFile()
    {
        ["fileName" => $fileName, "filePath" => $filePath] = $this->getMigrationFileDetails();
        $this->files->exists($filePath) and $this->files->move($filePath, "{$this->getModulePath()}/Database/Migrations/$fileName");
    }


    /**
     * @return void
     */
    protected function publishRequestCriteria()
    {
        Artisan::call("make:criteria Request");
        $this->files->replaceInFile([
            "use ".CriteriaInterface::class,
            "implements CriteriaInterface",
            'return $model',
            '@param string',
        ],[
            "use ".RequestCriteria::class." as BaseCriteria",
            "extends BaseCriteria",
            'return parent::apply($model, $repository)',
            '@param mixed'
        ],"{$this->getModulePath()}/Criteria/RequestCriteria.php");
    }


    /**
     * @param bool $isCollection
     * @return void
     */
    public function publishResource(bool $isCollection)
    {
        $command = "module:make-resource {$this->getModuleName()}Resource  {$this->getModuleName()}";
        Artisan::call($isCollection ? "$command --collection" : $command);
    }


    /**
     * @param bool $canPublishTransformer
     * @return void
     */
    public function publishPresenter(bool $canPublishTransformer)
    {
        $canPublishTransformer and Artisan::call("make:transformer {$this->getModuleName()}");
        Artisan::call("make:presenter {$this->getModuleName()} -n");
        $this->info(PHP_EOL);
    }


    /**
     * @return void
     */
    public function publishTraits()
    {
       $this->files->copyDirectory(app_path('Traits'), $traitsPath = "{$this->getModulePath()}/Traits");
       $this->getDirFiles($traitsPath)->each(function($fileName) use ($traitsPath) {
           $this->updateNameSpace("$traitsPath/$fileName");
           $this->files->replaceInFile('moduleName', Str::lower($this->getModuleName()),"$traitsPath/$fileName");
       });
    }


    /**
     * @return void
     */
    public function publishEnums()
    {
       $this->files->copyDirectory(app_path('Enums'), $enumsPath = "{$this->getModulePath()}/Enums");
       $this->getDirFiles($enumsPath)->each(fn($fileName) => $this->updateNameSpace("$enumsPath/$fileName"));
    }


    /**
     * @return string
     */
    protected function getModulePath(): string
    {
        return base_path("Modules/{$this->getModuleName()}");
    }


    /**
     * @return string
     */
    protected function getModuleNameSpace(): string
    {
        return "Modules\\{$this->getModuleName()}";
    }


    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return Str::studly($this->argument("moduleName"));
    }


    /**
     * @param string $path
     * @return void
     */
    protected function updateNameSpace(string $path)
    {
        $this->files->replaceInFile("App\\", "{$this->getModuleNameSpace()}\\", $path);
    }


    /**
     * @return void
     */
    public function publishBaseServices()
    {
        $this->files->makeDirectory($servicesPath = "{$this->getModulePath()}/Services");
        $serviceContent = "<?php {$this->delimiter(count: 2)}namespace {$this->getModuleNameSpace()}\Services; {$this->delimiter(count: 2)}";
        $serviceContent .= "class BaseService {$this->delimiter()}{{$this->delimiter()}";
        $serviceContent .= "{$this->delimiter(char: ' ', count: 4)} public function execute(){$this->delimiter()}";
        $serviceContent .= "{$this->delimiter(char: ' ', count: 5)}{{$this->delimiter(count: 2)}{$this->delimiter(char: ' ', count: 5)}}{$this->delimiter()}}";
        $this->files->put("$servicesPath/BaseService.php", $serviceContent);
    }


    /**
     * @param $path
     * @return Collection
     */
    public function getDirFiles($path) : Collection
    {
        return collect(scandir($path))->reject(fn($fileName) => in_array($fileName, ['.','..']));
    }


    /**
     * @return array
     */
    #[ArrayShape(['fileName' => "string|null", 'filePath' => "null|string"])]
    public function getMigrationFileDetails(): array
    {
        $snakeCaseModuleName = Str::snake($this->getModuleName());
        $migrationPath = database_path('migrations');
        $fileName = collect(scandir($migrationPath))->firstWhere(fn($fileName) => Str::contains($fileName, $snakeCaseModuleName));

        return [
            'fileName' => $fileName,
            'filePath' => $fileName ? "$migrationPath/$fileName" : null
        ];
    }


    /**
     * @param string $char
     * @param int $count
     * @return string
     */
    public function delimiter(string $char = PHP_EOL, int $count = 1): string
    {
       return str_repeat($char, $count);
    }


    /**
     * @return void
     */
    protected function getStub(){}
}
