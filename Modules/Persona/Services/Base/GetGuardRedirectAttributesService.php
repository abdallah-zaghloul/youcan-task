<?php

namespace Modules\Persona\Services\Base;

use Modules\Persona\Traits\GuardRedirectHandler;

/**
 *
 */
class GetGuardRedirectAttributesService
{
    use GuardRedirectHandler;

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        try {
            $guard = static::getGuard();
            $guardAttributes = @static::getGuardRedirectAttributes()->get($guard);
            $guardAttributes['guard'] = $guard;
            return $guardAttributes;
        }catch (\Exception){
            return null;
        }
    }
}
