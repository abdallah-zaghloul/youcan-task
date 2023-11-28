<?php

namespace Modules\Persona\Presenters;

use Modules\Persona\Transformers\AdminTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AdminPresenter.
 *
 * @package namespace Modules\Persona\Presenters;
 */
class AdminPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AdminTransformer();
    }
}
