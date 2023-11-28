<?php

namespace Modules\Persona\Services\Base;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application as Foundation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Validation\Validator as ValidatorInterface;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Persona\Models\User;
use Modules\Persona\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules;
use Modules\Persona\Repositories\UserRepository;


/**
 *
 */
trait WebAuthenticationService
{
    /*
    |--------------------------------------------------------------------------
    | Authentication Service
    |--------------------------------------------------------------------------
    |
    | This service handles authenticating users for the application and
    | redirecting them to your home screen. The service uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,
        ConfirmsPasswords,
        SendsPasswordResetEmails,
        RegistersUsers,
        ResetsPasswords,
        VerifiesEmails;

    /**
     * @var string
     */
    private string $guard = "web";
    /**
     * @var string
     */
    private string $table = "users";


    /**
     * Declare which Vendor Auth Trait at run time to avoid these methods collision
     * credentials(), rules(), validationErrorMessages(), broker()
     * at following Illuminate\Foundation\Auth\:
     * {AuthenticatesUsers, ConfirmsPasswords, SendsPasswordResetEmails, RegistersUsers, ResetsPasswords, VerifiesEmails}
     * @return string
     */
    abstract protected function useVendorTrait(): string;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::USER_HOME;

    /**
     * @return Renderable
     */
    public function showConfirmForm(): Renderable
    {
        return view("persona::user.password-confirm");
    }


    /**
     * @return Renderable
     */
    public function showLinkRequestForm(): Renderable
    {
        return view("persona::user.password-email");
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return ValidatorInterface
     */
    protected function validator(array $data): ValidatorInterface
    {
        return Validator::make($data, [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:$this->table"],
            "password" => ["required", "string", "min:8", "confirmed"],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        return app(UserRepository::class)->create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
        ]);
    }


    /**
     * @return Guard|Application|StatefulGuard|Foundation|Factory
     */
    protected function guard(): Guard|Application|StatefulGuard|Foundation|Factory
    {
        return auth($this->guard);
    }


    /**
     * @return View|Application|ViewFactory|Foundation
     */
    public function showRegistrationForm(): View|Application|ViewFactory|Foundation
    {
        return view("persona::user.register");
    }


    /**
     * @param Request $request
     * @return Foundation|Application|JsonResponse|RedirectResponse|Redirector|mixed
     * @throws ValidationException
     */
    public function register(Request $request): mixed
    {
        $this->validator($request->all())->validate();
        //registered user event
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        if ($response = $this->registered($request, $user))
            return $response;

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }


    /**
     * @param Request $request
     * @return Renderable
     */
    public function showResetForm(Request $request): Renderable
    {
        $token = $request->route()->parameter("token");

        return view("persona::user.password-reset")->with([
            "token" => $token,
            "email" => $request->email
        ]);
    }


    /**
     * @param Request $request
     * @return Application|View|ViewFactory|Redirector|Foundation|RedirectResponse
     */
    public function show(Request $request): Application|View|Factory|Redirector|Foundation|RedirectResponse
    {
        return $request->user($this->guard)->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view("persona::user.verify");
    }


    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function resend(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user($this->guard)->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath());
        }

        $request->user($this->guard)->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse([], 202)
            : back()->with("resent", true);
    }

    public function rules(): array
    {
        return [
            ResetsPasswords::class => [
                "token" => "required",
                "email" => ["required", "email"],
                "password" => ["required", "confirmed", Rules\Password::defaults()],
            ],
            ConfirmsPasswords::class => [
                "password" => ["required", "current_password:$this->guard"],
            ],
        ][$this->useVendorTrait()];
    }

    public function credentials(Request $request): array
    {
        return [
            AuthenticatesUsers::class => $request->only($this->username(), "password"),
            SendsPasswordResetEmails::class => $request->only("email"),
            ResetsPasswords::class => $request->only("email", "password", "password_confirmation", "token"),
        ][$this->useVendorTrait()];
    }


    public function validationErrorMessages(): array
    {
        return [];
    }


    public function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
