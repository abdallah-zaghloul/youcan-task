<?php

namespace Modules\Ecommerce\Presenters;

use League\Fractal\TransformerAbstract;
use Modules\Ecommerce\Transformers\CategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoryPresenter.
 *
 * @package namespace Modules\Ecommerce\Presenters;
 */
class CategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return CategoryTransformer|TransformerAbstract
     */
    public function getTransformer(): CategoryTransformer|TransformerAbstract
    {
        return new CategoryTransformer();
    }
}
