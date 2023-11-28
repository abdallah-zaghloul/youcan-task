<?php

namespace Modules\Ecommerce\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Modules\Ecommerce\Http\Requests\CreateProductRequest;
use Modules\Ecommerce\Services\CreateProductService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'create:product {name} {price} {--description=} {--category_ids=}';


    /**
     * The console command description.
     */
    protected $description = 'Create product from CLI  {name} {price} {--description=any} {--category_ids=1,2,3}';


    /**
     * @var CreateProductRequest
     */
    protected CreateProductRequest $request;


    /**
     * @var CreateProductService
     */
    protected CreateProductService $service;


    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->request = app(CreateProductRequest::class);
        $this->service = app(CreateProductService::class);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->request->merge([
            'name' => $this->argument('name'),
            'price' => $this->argument('price'),
            'description' => $this->option('description'),
            'category_ids' => explode(',', $this->option('category_ids')),
        ]);

        if ($errorMessage = $this->validationErrorMessage()){
            $this->error($errorMessage);
            return;
        }

        $this->service->execute($this->request);
        $this->info(trans("ecommerce::messages.success"));
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }


    /**
     * @return string|null
     */
    protected function validationErrorMessage(): ?string
    {
        try {
            $this->request->validate($this->request->rules());
            return null;
        } catch (\Exception $exception) {
            return match (true) {
                $exception instanceof ValidationException => collect($exception->errors())->flatten()->implode(PHP_EOL),
                default => $exception->getMessage()
            };
        }
    }
}
