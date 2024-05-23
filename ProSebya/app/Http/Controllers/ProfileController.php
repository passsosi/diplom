<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\models\Risk;
use App\models\CaseResult;
use App\models\CaseModel;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
 {
    public function profileOutput()
 {
        $user = auth()->user();

        return view( 'profile', [
            'user' => $user,
        ] );
    }

    public function userProfile( $user_id )
 {
        $user = User::where( 'id', $user_id )->get();
        $caseResult = caseResult::where( 'user_id', $user_id )->get();
        $risk = Risk::where( 'user_id', $user_id )->get();
        $cases = [];
        $i = 0;
        foreach ( $caseResult as $el ) {
            if ( $i === 0 || $cases[ $i-1 ] != $el->case_id ) {
                $cases[ $i ] = $el->case_id;
                $i++;
            }
        }
        $case = CaseModel::whereIn( 'id', $cases )->get();
        return view( 'user-profile', [
            'user' => $user[ 0 ],
            'cases' => $case,
            'risk' => $risk
        ] );
    }

    public function profileEditOutput()
 {
        $user = auth()->user();

        return view( 'profile-edit', [
            'user' => $user,
        ] );
    }

    public function profileEdit( Request $request )
 {
        $user = auth()->user();

        $request->validate( [
            'name' => 'required|string',
            'surname' => 'required|string',
            'age' => 'required|int',
        ] );
        $imgReq = $request->file( 'image' );
        if ( $imgReq != null ) {
            $img = file_get_contents( $imgReq->getRealPath() );
            $image = $img;
        }
        else{
            $img = $user->image;
        }

        $age = ( int )$request->input( 'age' );
        if ( !$age ) {
            return redirect( route( 'editProfileView' ) )->withErrors( [ 'age' => 'Укажите возраст целым числом' ] );
        }

        $name = $request->input( 'name' );
        $surname = $request->input( 'surname' );
        $patronymic = $request->input( 'patronymic' );
        $age = $age;
       

        $user->update( [
            'name' => $name,
            'surname' => $surname,
            'patronymic' => $patronymic,
            'age' => $age,
            'image' => $img,
        ] );
        $user->save();

        return view( 'profile-edit', [
            'user' => $user,
        ] );

    }

    public function profileEditAuth( Request $request )
 {
        $user = auth()->user();

        $request->validate( [
            'email' => 'required|string',
            'newpassword' => [ 'required', 'string', 'min:8' ],
        ] );
        $formFields = [];
        $formFields['email'] = $user->email;
        $formFields['password'] = $request->input( 'password');
        if ( Auth::attempt( $formFields ) ) {
            $user->update( [
                'email' => $request->input( 'email' ),
                'password' => Hash::make( $request->input( 'newpassword' ) ),
            ] );
            $user->save();
        } else {
            return redirect( route( 'editProfileView' ) )->withErrors( [ 'password' => 'Неверный пароль' ] );
        }
    }

    public function compView( $id )
 {
        return view( 'compTestPage', [
            'req' => $req
        ] );
    }
}