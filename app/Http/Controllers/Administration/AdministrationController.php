<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AdministrationResource;
use Notification;
use App\Notifications\Administration\AdministrationNotification;
use App\Models\Administration;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class AdministrationController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware('auth:administrations', ['except' => ['login','forgotpassword','resetpassword','store']]);
    }

    // Login
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('administrations')->attempt($credentials)) {
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

    // index
    public function index(Request $request)
    {
        if( $request->created_at ) {
            $administration = Administration::Orderby( $request->sortby , $request->orderby )->whereDate( 'created_at', $request->created_at )->paginate($request->paginate);
        }

        elseif( $request->updated_at ) {
            $administration = Administration::Orderby( $request->sortby , $request->orderby )->whereDate( 'updated_at', $request->updated_at )->paginate($request->paginate);
        }

        elseif( $request->date_from && $request->date_to ) {
            $administration = Administration::Orderby( $request->sortby , $request->orderby )->whereDate('created_at', [$request->date_from, $request->date_to])->paginate($request->paginate);
        }

        elseif( $request->expand ) {
            return new AdministrationResource(Administration::findOrFail($request->expand));
        }
        elseif( $request->filter ) {
            $administration = Administration::Orderby( $request->sortby , $request->orderby )->where( $request->filter, 'LIKE', "%$request->filtervalue%" )->get();
        } else {
            $administration = Administration::Orderby( $request->sortby , $request->orderby )->paginate($request->paginate);
        }
        
        
        
        return AdministrationResource::collection($administration);
    }

    // store
    public function store(Request $request)
    {
        $administration = new Administration();
        $administration->email = $request->email;
        $administration->password = bcrypt($request->password);
        $administration->save();

        $offerData = [
            'name' => 'BOGO',
            'body' => 'You received an offer.',
            'thanks' => 'Thank you',
            'offerText' => 'Check out the offer',
            'offerUrl' => url('/'),
            'offer_id' => 007
        ];

        Notification::send($administration, new AdministrationNotification($administration));

        return "created";
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
        $administration = Administration::find($id);
        $administration->email = $request->email;
        $administration->password = bcrypt($request->password);
        $administration->save();

        return 'Updated';
    }

    // destroy
    public function destroy($id)
    {
        $administration = Administration::withTrashed()
        ->where('id', $id);
        $user->delete();
        return 'delete';
    }

    // trashed
    public function trashed() {
        $administrations = Administration::onlyTrashed()->get();
        return AdministrationResource::collection($administrations);
    }

    // restore
    public function restore($id) {
        $administration = Administration::onlyTrashed()
        ->where('id', $id);
        $administration->restore();
        return 'restore';
    }

    // forced
    public function forced($id) {
        $administration = Administration::onlyTrashed()
        ->where('id', $id);
        $administration->forceDelete();
        return 'forced';
    }

    // auth
    public function me()
    {
        return response()->json(auth()->user());
    }

    // logout
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // refresh
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // respondWithToken
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
