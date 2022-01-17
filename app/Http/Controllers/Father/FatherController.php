<?php

namespace App\Http\Controllers\Father;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\FatherResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

use App\Models\Father;


class FatherController extends Controller
{
    // Login
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    // forgot password
    public function forgotpassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        };
    
        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);
    }

    // reset password
    public function resetpassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
    
                $user->tokens()->delete();
    
                event(new PasswordReset($user));
            }
        );
    
        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }
    
        return response([
            'message'=> __($status)
        ], 500);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->created_at ) {
            $father = Father::Orderby( $request->sortby , $request->orderby )->whereDate( 'created_at', $request->created_at )->paginate($request->paginate);
        }

        elseif( $request->updated_at ) {
            $father = Father::Orderby( $request->sortby , $request->orderby )->whereDate( 'updated_at', $request->updated_at )->paginate($request->paginate);
        }

        elseif( $request->date_from && $request->date_to ) {
            $father = Father::Orderby( $request->sortby , $request->orderby )->whereDate('created_at', [$request->date_from, $request->date_to])->paginate($request->paginate);
        }

        elseif( $request->expand ) {
            return new FatherResource(Father::findOrFail($request->expand));
        }
        elseif( $request->filter ) {
            $father = Father::Orderby( $request->sortby , $request->orderby )->where( $request->filter, 'LIKE', "%$request->filtervalue%" )->get();
        } else {
            $father = Father::Orderby( $request->sortby , $request->orderby )->paginate($request->paginate);
        }
        
        
        
        return FatherResource::collection($father);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $father = new Father;
        $father->email = $request->email;
        $father->password = bcrypt($request->password);
        $father->save();

        return "created";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $father = Father::find($id);
        $father->email = $request->email;
        $father->password = bcrypt($request->password);
        $father->save();

        return 'Updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $father = Father::withTrashed()
        ->where('id', $id);
        $user->delete();
        return 'delete';
    }

    // trashed
    public function trashed() {
        $fathers = Father::onlyTrashed()->get();
        return FatherResource::collection($fathers);
    }

    // restore
    public function restore($id) {
        $father = Father::onlyTrashed()
        ->where('id', $id);
        $father->restore();
        return 'restore';
    }

    // forced
    public function forced($id) {
        $father = Father::onlyTrashed()
        ->where('id', $id);
        $father->forceDelete();
        return 'forced';
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
