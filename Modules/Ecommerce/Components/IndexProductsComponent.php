<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace Modules\Ecommerce\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Ecommerce\Services\IndexProductService;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 *
 */
class IndexProductsComponent extends Component
{
    use WithPagination;

    /**
     * livewire global variables
     * @var
     */
    public $categoryName, $sortBy, $dir;


    /**
     * @var IndexProductService
     */
    protected IndexProductService $indexProductService;

    /**
     *
     */
    public function __construct()
    {
        $this->indexProductService = app(IndexProductService::class);
    }


    /**
     * livewire constructor
     * @return void
     */
    public function mount()
    {
        $this->fill(request()->query());
    }


    /**
     * @throws RepositoryException
     */
    public function render(): Renderable
    {
        return view('ecommerce::components.products', [
            'products' => $this->indexProductService->execute()
        ]);
    }


    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'categoryName' => ['nullable', 'max:191'],
            'sortBy' => ['nullable', ValidationRule::in('price', 'created_at')],
            'dir' => ['nullable', ValidationRule::in('asc', 'desc')],
        ];
    }


    /** validate (there are an issue with livewire TODO
     * public function search()
     * {
     *      $this->validate();
     * }
     */
}
