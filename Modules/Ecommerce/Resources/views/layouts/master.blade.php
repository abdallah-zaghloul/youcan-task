
{{-- this is the only call for persona module ... it can be called using http (microservice)--}}
@php($guardAttributes = app(\Modules\Persona\Services\Base\GetGuardRedirectAttributesService::class)->execute())
@extends(match ($guardAttributes['guard']){
    'web'=> 'persona::user.home',
    'adminWeb'=> 'persona::admin.home',
    default => 'persona::layouts.app'
})
