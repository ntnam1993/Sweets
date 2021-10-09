<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Jenssegers\Agent\Agent;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // return parent::render($request, $exception);

        // detech mobile or pc
        $agent = app(Agent::class);
        // render PC view for iPad
        $isMobile = $agent->isMobile() && !$agent->isIpad() ? true : false;
        $path = $isMobile ? 'mobile.' : '';

        // write exception to log file
        $url = $request->url();
        $data = [
            'URL' => $url,
            'File' => $exception->getFile(),
            'Line' => $exception->getLine(),
            'Message' => $exception->getMessage(),
        ];

        $logData = '=============== ' . date('Y-m-d H:i:s') . " ===============\n";
        $logData .= print_r($data, true) . "\n";
        file_put_contents(storage_path() . '/logs/exception.log', $logData, FILE_APPEND | LOCK_EX);

        // logout if token fail
        if ($exception instanceof \League\OAuth2\Client\Provider\Exception\IdentityProviderException) {
            return redirect(env('SWEETS_LOGOUT_ENDPOINT'));
        }

        if (!$request->ajax()) {
            //Redirect to 404 page
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return \Response::view('errors.' . $path . '404', ['Server errror' => 404], 404);
            }

            // return 500 page if has problem with API
            if ($exception instanceof \GuzzleHttp\Exception\TransferException) {
                return \Response::view('errors.' . $path . '500', ['Server errror' => 500], 500);
            }

            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                return \Response::view('errors.' . $path . '500', ['Server errror' => 500], 500);
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                return back()->withInput();
            }

            return \Response::view('errors.' . $path . '500', ['Server errror' => 500], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
