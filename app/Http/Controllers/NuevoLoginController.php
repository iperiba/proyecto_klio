<?php

namespace App\Http\Controllers;

    use Validator;
    use Session;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\User;
    use Hash;

    class NuevoLoginController extends Controller
    {
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */


    public function autentificacion_ampliada(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            if (NuevoLoginController::existencia_usuario($request)==true) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'autorizado' => true])) {
                    return redirect()->route('home');
                } else {
                    Session::flash('message', "Usuario no autorizado todavía");
                    return redirect()->route('login')->withInput();
                }
            } else {
                Session::flash('message', "El email y/o la contraseña no fueron reconocidos");
                return redirect()->route('login')->withInput();
            }
        }
    }

    public function existencia_usuario($request) {
        $existe_user = false;
        $user_buscado = User::where([
            ['email', '=', $request->email],
        ])->first();

        if ($user_buscado!=null) {
            if (Hash::check($request->password, $user_buscado->password)) {
                $existe_user = true;
            }
        }

        return $existe_user;
    }
}
