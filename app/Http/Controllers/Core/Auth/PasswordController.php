<?php

namespace App\Http\Controllers\Core\Auth;

// use App\Core\Repositories\AdminRepository;
// use App\Core\Repositories\TeacherRepository;
use App\Events\Email\CompleteRegistrationEvent;
use App\Events\Email\PasswordResetTokenCreated;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Password;

/**
 * @property-read string $broker
 */
abstract class PasswordController extends Controller
{
    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
    }

    /**
     * Send password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        $this->validateEmailAddress($request);

        $broker = Password::broker($this->getBroker());
        $user = $broker->getUser($this->getProvidedEmail($request));
        $token = Password::getRepository()->create($user);

        event(new PasswordResetTokenCreated($user->email, $token, $this->getGuard()));

        return $this->response(trans('passwords.sent'));
    }

    /**
     * Store new password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|exists:' . $this->getBroker(),
                'password' => 'required|confirmed|min:6',
                'token' => 'required',
            ],
            ['email.exists' => trans('passwords.user')]
        );

        $repository = $this->getRepository();
        if ($repository->isValidInvitation($request->only(['email', 'token']))) {
            $repository->registerPassword($request->get('email'), $request->get('password'));
            $user = $repository->findBy('email', $request->get('email'));
            event(new CompleteRegistrationEvent($user->email, $this->getGuard()));
            return $this->response(trans('passwords.updated'));
        }

        return $this->response(trans('passwords.invalid_token'), 400);
    }

    /**
     * Validate the request of sending reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateEmailAddress($request)
    {
        $this->validate($request, ['email' => 'required|email|exists:' . $this->getBroker()], [
            'email.exists' => trans('passwords.user'),
        ]);
    }

    /**
     * Get the user-provided email address.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getProvidedEmail($request)
    {
        return $request->only('email');
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, $this->getResetValidationRules());
        if ($this->invalidToken($request, $request->get('token'))) {
            return $this->response(trans('passwords.token'), 400);
        }

        $credentials = $this->getResetCredentials($request);

        $response = Password::broker($this->getBroker())->reset($credentials, function ($user, $password) {
            $this->storePasswordAndLogin($user, $password);
        });

        if ($response === Password::PASSWORD_RESET) {
            return $this->response(trans('passwords.reset'));
        }

        return $this->response(trans('passwords.user'), 400);
    }

    /**
     * Check for invalid reset token.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $token
     * @return bool
     */
    public function invalidToken($request, $token)
    {
        $broker = $this->getBroker();

        return !Password::broker($broker)
            ->tokenExists(Password::broker($broker)->getUser($request->only('email')), $token);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function getResetValidationRules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getResetCredentials($request)
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function storePasswordAndLogin($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => str_random(60),
        ])->save();

        Auth::guard($this->getGuard())->login($user);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     */
    public function getBroker()
    {
        return property_exists($this, 'broker') ? $this->broker : null;
    }

    /**
     * Get the repository for each type.
     *
     * @return string|null
     */
    // public function getRepository()
    // {
    //     if ($this->getGuard() === 'admin') {
    //         return app(AdminRepository::class);
    //     }

    //     return app(TeacherRepository::class);
    // }
}
