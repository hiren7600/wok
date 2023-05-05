<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Throwable;
use Response;
use App\Models\Conversation;
use App\Models\Friend;
use App\Models\UserNotification;
use App\Models\User;




class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
         dd($e);
        // Set Error massage for error page
        $data       = [];
        // If this exception is an instance of HttpException
        if ($this->isHttpException($e)) {
            // Grab the HTTP status code from the Exception
            $statuscode = $e->getStatusCode();
        }

        if (!isset($statuscode)) {
            $statuscode = 500;
        }

        $data['statuscode'] = $statuscode;

        // GET ERROR MESSAGE
        $message    = $e->getMessage();
        if (empty($message)) {
            if ($statuscode == 404) {
                $message = getTranslation('Page not found!');
            } else {
                $message = getTranslation('Something went wrong!');
            }
        }


        $data['subtitle']   = $message;
        $data['pagetitle']  = $statuscode . ' - ' . $message;
        $data['header_title'] = 'OOPS';

        $user = Auth::guard()->user();

        if($user) {

            $conversationsCountcollection = Conversation::where('to_id',$user->user_id)
                                            ->orwhere(function($query) use($user) {
                                                $query->where('is_replied', 1)->where('from_id',$user->user_id);
                                            })
                                            ->with(['conversationmessages' => function($query) use ($user) {
                                                $query->where('is_read', 0)
                                                        ->where('user_id', '!=',$user->user_id)->get();
                                            }])->get();
            $conversationsCount = 0;
            if(!$conversationsCountcollection->isEmpty()) {
                foreach ($conversationsCountcollection as $conversationCnts) {
                    foreach ($conversationCnts->conversationmessages as $conversationCnt) {
                        $conversationsCount++;
                    }
                }
            }
            $globaldata['newMsgCounts'] = $conversationsCount;

            $friends = Friend::where('to_user_id', $user->user_id)->where('status', 0)->get();
            $globaldata['friendrequestcounts'] = $friends->count();

            $users = User::where('status', 1)->get();
            $globaldata['usercounts'] = $users->count();

            $globaldata['notificationcount'] = UserNotification::where('user_id', $user->user_id)->where('is_read', 0)->count();
        }

        // dd(Auth::guard('admin')->user());
        if ($request->is('manage/*')) {
            if (Auth::guard('admin')->check()) {
                $admin = Auth::guard('admin')->user();


                if ($request->ajax()) {

                    $data['type']       = 'error';
                    $data['caption']    = $message;
                    return response()->json($data);
                } else {
                    $globaldata['admin']                = $admin;
                    $data['globaldata']                 = $globaldata;
                    $view                               = view_admin('errors.error-postlogin', $data)->render();

                    return response($view, $statuscode);
                }
            } else {

                if ($request->ajax()) {
                    $data['type']       = 'error';
                    $data['caption']    = $message;
                    return response()->json($data);
                } else {

                    $view = view_admin('errors.error-prelogin', $data)->render();
                    return response($view, $statuscode);
                }
            }
        } else {
            if (Auth::guard()->check()) {
                $user = Auth::guard()->user();


                if ($request->ajax()) {

                    $data['type']       = 'error';
                    $data['caption']    = $message;
                    return response()->json($data);
                } else {
                    $globaldata['user']                = $user;
                    $data['globaldata']                 = $globaldata;
                    $view                               = view_front('errors.404', $data)->render();

                    return response($view, $statuscode);
                }
            } else {

                if ($request->ajax()) {
                    $data['type']       = 'error';
                    $data['caption']    = $message;
                    return response()->json($data);
                } else {

                    $view = view_front('errors.404', $data)->render();
                    return response($view, $statuscode);
                }
            }
        }


        return parent::render($request, $e);

        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            if ($request->ajax()) {
                $data = [];
                $data['type'] = 'error';
                $data['caption'] = getTranslation('Something went wrong!');
                $data['errormessage'] = getTranslation('Please refresh the page and try again.');
                $data['redirectUrl'] = url('/');
                $data['new_token'] = csrf_token();
                return response()->json($data);
            }
        }

        return parent::render($request, $exception);
    }
}
