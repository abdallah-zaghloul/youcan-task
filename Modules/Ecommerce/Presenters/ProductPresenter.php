<?php

namespace Modules\Ecommerce\Presenters;

use League\Fractal\TransformerAbstract;
use Modules\Ecommerce\Transformers\ProductTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProductPresenter.
 *
 * @package namespace Modules\Ecommerce\Presenters;
 */
class ProductPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return ProductTransformer|TransformerAbstract
     */
    public function getTransformer(): ProductTransformer|TransformerAbstract
    {
        return new ProductTransformer();
    }
}
