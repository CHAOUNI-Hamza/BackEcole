<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentRequest;
use Illuminate\Validation\Rules\Password as RulesPassword;

class StudentController extends Controller
{


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:students', ['except' => ['login','forgotpassword','resetpassword','store']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('students')->attempt($credentials)) {
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
            function ($Student) use ($request) {
                $Student->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
    
                $Student->tokens()->delete();
    
                event(new PasswordReset($Student));
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
            $users = Student::Orderby( $request->sortby , $request->orderby )->whereDate( 'created_at', $request->created_at )->paginate($request->paginate);
        }

        elseif( $request->updated_at ) {
            $users = Student::Orderby( $request->sortby , $request->orderby )->whereDate( 'updated_at', $request->updated_at )->paginate($request->paginate);
        }

        elseif( $request->date_from && $request->date_to ) {
            $users = Student::Orderby( $request->sortby , $request->orderby )->whereDate('created_at', [$request->date_from, $request->date_to])->paginate($request->paginate);
        }

        elseif( $request->expand ) {
            return new StudentResource(Student::findOrFail($request->expand));
        }
        elseif( $request->filter ) {
            $users = Student::Orderby( $request->sortby , $request->orderby )->where( $request->filter, 'LIKE', "%$request->filtervalue%" )->get();
        } else {
            $users = Student::Orderby( $request->sortby , $request->orderby )->paginate($request->paginate);
        }
        
        
        
        return StudentResource::collection($users);
    }
    
    
    public function store(StudentRequest $request)
    {
        //return $request->all();
        $student = new Student;
        $student->nom = $request->nom;
        $student->prenom = $request->prenom;
        $student->niveau_scolaire = $request->niveau_scolaire;
        $student->type_niveau = $request->type_niveau;
        $student->photo = $request->photo;
        $student->num_matricule = $request->num_matricule;
        $student->sex = $request->sex;
        $student->email = $request->email;
        $student->date_naissance = $request->date_naissance;
        $student->password = bcrypt($request->password);
        $student->save();

        return 'created';
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
        $student = Student::find($id);
        $student->nom = $request->nom;
        $student->prenom = $request->prenom;
        $student->niveau_scolaire = $request->niveau_scolaire;
        $student->type_niveau = $request->type_niveau;
        $student->photo = $request->photo;
        $student->num_matricule = $request->num_matricule;
        $student->sex = $request->sex;
        $student->email = $request->email;
        $student->date_naissance = $request->date_naissance;
        //$student->password = bcrypt($request->password);
        $student->save();

        return 'Updated';
    }

    // trashed
    public function trashed() {
        $students = Student::onlyTrashed()->get();
        return StudentResource::collection($students);
    }

    // delete
    public function destroy($id) {
        $student = Student::withTrashed()->where('id', $id);
        $student->delete();
        return 'delete';
    }

    // restore
    public function restore($id) {
        $student = Student::onlyTrashed()
        ->where('id', $id);
        $student->restore();
        return 'restore';
    }

    // forced
    public function forced($id) {
        $student = Student::onlyTrashed()
        ->where('id', $id);
        $student->forceDelete();
        return 'forced';
    }

    /**
     * Get the authenticated Student.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->Student());
    }

    /**
     * Log the student out (Invalidate the token).
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
