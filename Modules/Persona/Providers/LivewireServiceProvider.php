<?php

namespace Modules\Persona\Providers;
use Illuminate\Support\Str;
use Livewire\Livewire;

use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //add livewire components
        [$componentsDir, $namespace] = [module_path('persona','Services/Web/Components'), "Modules\\Persona\\Services\\Web\\Components"];
        collect(scandir($componentsDir))->each(fn($fileName) => $this->loadLivewireComponent($fileName, $namespace));
    }

    protected function loadLivewireComponent(string $fileName, string $namespace): void
    {
        $className = match ($fileName){
            '.','..','.gitkeep' => null,
            default => Str::remove('.php',$fileName)
        };

        if (!empty($className))
        Livewire::component("persona::".Str::kebab(Str::replace(['Service','Component'],'',$className)),"$namespace\\$className");
    }
}
