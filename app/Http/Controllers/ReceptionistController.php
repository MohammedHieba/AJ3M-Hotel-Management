<?php

namespace App\Http\Controllers;

use App\DataTables\ReceptionistDataTable;
use App\Http\Requests\StoreReceptRequest;
use App\Models\Manager;
use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionistController extends Controller
{
    public function index(ReceptionistDataTable $dataTable){
        return $dataTable->render('receptionist.index');
//        return view('manager.index',[
//            'recepts'   => User::all()->where('creator_id','=','1')
//        ]);
    }

    public function create(){
        return view('receptionist.create',[
            "managers" => Manager::all()
        ]);
    }

    public function store(StoreReceptRequest $request){
        $user = new User;
        $user->name = $request->recept_name;
        $user->email = $request->recept_email;
        $user->national_id = $request->recept_national_id;
        $user->password = $request->recept_password;
        $user->assignRole('receptionist');
        if($request->hasFile('recept_image')){
            $file = $request->file('recept_image');
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,['jpg','jpeg']);
            if($check){
                $user->avatar_image = $request->recept_image;
            } else {
                dd("to do show fail message for extension");
            }
        }
        $user->save();
        dd($user->manager());
        $receptionist = new Receptionist;
        if($request->manager_id){
            $receptionist->manager_id = $request->manager_id;
        } else { 
            $receptionist->manager_id = Auth::user()->id;
        }
        $receptionist->receptionist_id = $user->id;
        $receptionist->save();
        return redirect()->route('receptionist.index');
    }
}