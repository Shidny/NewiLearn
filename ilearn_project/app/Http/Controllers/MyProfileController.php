<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\MainController;
use Aws\S3\S3Client;

class MyProfileController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');

            return view('my_profile')->with('user',$user);
        }else{
            return view('Login');
        }
        
    }

    public function update_profile(Request $request){

        if($request->password == ''){
            $data = DB::select('exec [SP_FETCH_EDIT_USERS] @id=?', array($request->id));
                
            $hashed_password = $data[0]->password;
        }else{
            $hashed_password = password_hash($request->password, PASSWORD_DEFAULT);
        }
        

        // dd($hashed_password);
        $data = DB::select('exec [SP_UPDATE_PROFILES] @id=?
        ,@password=? 
        ,@firstname=?
        ,@middlename=?
        ,@lastname=?'
        ,array($request->id
            ,$hashed_password
            ,$request->firstname
            ,$request->middlename
            ,$request->lastname));
        
        // dd($data);
        if ($data) {
            return response()->json(['status' => true, 'msg' => ['Success'], 'data' => $data[0]]);
        } else {
            return response()->json(['status' => false, 'msg' => ['No Data']]);
        }      
    }

    public function department_func(Request $request){
        $result_department =  DB::select('EXEC [SP_FETCH_DEPARTMENT_ID] ?',array($request->session()->get('user')->department));
        if ($result_department) {
            return response()->json(['status' => true, 'msg' => 'true','user_department' => $result_department]);
        }else{
            return response()->json(['status' => false, 'msg' => 'false','user_department' => '']);
        }
        // dd($result_department);
    }

}
