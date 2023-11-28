<?php

namespace Modules\Ecommerce\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class EcommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('ecommerce::index');
    }
}
