<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProfessorResource;
use App\Models\Professor;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class ProfessorController extends Controller
{
    // middleware
    public function __construct()
    {
        $this->middleware('auth:professors', ['except' => ['login','forgotpassword','resetpassword','store']]);
    }

    // Login
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('professors')->attempt($credentials)) {
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
            $professor = Professor::Orderby( $request->sortby , $request->orderby )->whereDate( 'created_at', $request->created_at )->paginate($request->paginate);
        }

        elseif( $request->updated_at ) {
            $professor = Professor::Orderby( $request->sortby , $request->orderby )->whereDate( 'updated_at', $request->updated_at )->paginate($request->paginate);
        }

        elseif( $request->date_from && $request->date_to ) {
            $professor = Professor::Orderby( $request->sortby , $request->orderby )->whereDate('created_at', [$request->date_from, $request->date_to])->paginate($request->paginate);
        }

        elseif( $request->expand ) {
            return new FatherResource(Professor::findOrFail($request->expand));
        }
        elseif( $request->filter ) {
            $professor = Professor::Orderby( $request->sortby , $request->orderby )->where( $request->filter, 'LIKE', "%$request->filtervalue%" )->get();
        } else {
            $professor = Professor::Orderby( $request->sortby , $request->orderby )->paginate($request->paginate);
        }
        
        
        
        return ProfessorResource::collection($professor);
    }


    // store
    public function store(Request $request)
    {
        $professor = new Professor;
        $professor->nom = $request->nom;
        $professor->prenom = $request->prenom;
        $hasFile = $request->hasFile('photo');
        
        if( $hasFile ) {
            $path = $request->file('photo')->store('public/professors');  
            $professor->photo = Storage::url($path);
        }
        
        $professor->sex = $request->sex;
        $professor->email = $request->email;
        $professor->date_naissance = $request->date_naissance;
        $professor->password = bcrypt($request->password);
        $professor->save();

        return 'created';
    }

    // update
    public function update(Request $request, $id)
    {
        if( $request->get('current-password') && $request->get('new-password')) {
            if (!(Hash::check($request->get('current-password'), Professor::find($id)->password))) {
                // The passwords matches
                return "errorYour current password does not matches with the password.";
            }
    
            if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
                // Current password and new password same
                return "error New Password cannot be same as your current password.";
            }
    
            /*$validatedData = $request->validate([
                'current-password' => 'required',
                'new-password' => 'required|string|min:8|confirmed',
            ]);*/
    
            //Change Password
            $ather = Professor::find($id);
            $professor->nom = $request->nom;
            $professor->prenom = $request->prenom;
            $hasFile = $request->hasFile('photo');
        
            if( $hasFile ) {
                $path = $request->file('photo')->store('public/students');  
                $professor->photo = Storage::url($path);
            }
        
            $professor->sex = $request->sex;
            $professor->email = $request->email;
            $professor->date_naissance = $request->date_naissance;
            $professor->password = bcrypt($request->password);
            $professor->save();

            return 'update';
        } else {
            $professor = Professor::find($id);
            $professor->nom = $request->nom;
            $professor->prenom = $request->prenom;
            $hasFile = $request->hasFile('photo');
        
            if( $hasFile ) {
                $path = $request->file('photo')->store('public/students');  
               $professor->photo = Storage::url($path);
            }
        
            $professor->sex = $request->sex;
            $professor->email = $request->email;
            $professor->date_naissance = $request->date_naissance;
            //$professor->password = bcrypt($request->password);
            $professor->save();

            return 'update';
    }
}

    // destroy
    public function destroy($id)
    {
        $professor = Professor::withTrashed()
        ->where('id', $id);
        $professor->delete();
        return 'delete';
    }

    // trashed
    public function trashed() {
        $professors = Professor::onlyTrashed()->get();
        return ProfessorResource::collection($professors);
    }

    // restore
    public function restore($id) {
        $professor = Professor::onlyTrashed()
        ->where('id', $id);
        $professor->restore();
        return 'restore';
    }

    // forced
    public function forced($id) {
        $professor = Professor::onlyTrashed()
        ->where('id', $id);
        $professor->forceDelete();
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

    //respondWithToken
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
