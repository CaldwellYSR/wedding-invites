<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use AppHttpControllersController;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;

class AuthenticateController extends Controller
{

    protected $auth;

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function index() {

    }

    public function authenticate(Request $request) {

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = $this->auth->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }

}
