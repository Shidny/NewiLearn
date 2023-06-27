<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\http\Controllers\MainController;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function __construct(MainController $MainController)
    {
        $this->MainController = $MainController;
    }

    public function index(Request $request)
    {
        // if ($request->session()->has('user')) {
        //     $user = $request->session()->get('user');
        //     return view('home')->with('user',$user);
        // }else{
        //     return view('login');
        // }
    }   

    public function forgotpassword(Request $request){
        return view('forgot_password');
    }

    public function forgot_password_url(Request $request){
        // dd($request->forgetemail);
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        $forget_password_form = array(
            'email' => 'email',
        );

        $this->MainController->setAttributeNames($forget_password_form);
        $validator->setAttributeNames($forget_password_form);

        // dd($request->forgetemail);

        $data = DB::select('exec [SP_FORGOTPASSWORD_LOGIN] @FORGET_EMPNO=?, @FORGET_EMAIL=?, @USER_ID=?, @PASSWORD=?, @StatementType=?', array($request->forgetempno,$request->forgetemail,'','',"SELECT"));


        if ($data){
            // dd($data);
            foreach ($data as $key => $value) {
                $user_id = $value->user_id;
                $full_name = $value->firstname .' '. $value->lastname;
                $firstname = $value->firstname;
                $middlename = $value->middlename;
                $lastname = $value->lastname;
                $email = $value->email;
                $username = $value->username;
                $password = $value->password;

                $hashed_password = password_hash($value->username, PASSWORD_DEFAULT);
                
                if ($user_id) {
                    // dd($user_id);
                    Db::update('exec [SP_FORGOTPASSWORD_LOGIN] @FORGET_EMPNO=?, @FORGET_EMAIL=?, @USER_ID=?, @PASSWORD=?, @StatementType=?', array('','',$user_id,$hashed_password ,"UPDATE"));

                    $data_array = [
                        'full_name'    => trim($full_name),
                        'firstname'    => trim($firstname),
                        'middlename'    => trim($middlename),
                        'lastname'    => trim($lastname),
                        'email'    => trim($email),
                        'username'    => trim($username),
                        'password'    => trim($password),
                    ];

                    $data = array("name" => "Cloudways (sender_name)", "body" => "A test mail");
                    $resultMail = Mail::send('sendmessage_reset_password', ['data' => $data_array], function ($message) use ($data_array) {
                    $message->to($data_array['email'], $data_array['full_name'])
                    ->subject("Reset Password Successful");
                    $message->from("no-reply.ilearn@rfc.com.ph", "Policy Portal");
                    });
                    
                    return response()->json(['status' => true, 'msg' => ['Success']]);
                    
                }  
            }
        }
        else{
            return response()->json(['status' => false, 'msg' => ['Data Not Found']]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user_acess = array(
            'username' => 'Username',
            'passwod' => 'Password',
        );
        $this->MainController->setAttributeNames($user_acess);
        $validator->setAttributeNames($user_acess);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->all()]);
            die();
        } else {
            //SP_LOGIN
            $usernmae = $request->username;
            $password = $request->password;

            $row =  DB::connection('sqlsrv')->select('exec SP_LOGIN ?', array($usernmae));
            if ($row) {
                
                if (password_verify($password, $row[0]->password)) {
                    $request->session()->put('user', $row[0]);
                    
                    // $request->session()->get('user')->id;
                    if ($row[0]->status == 2){
                        return response()->json(['status' => false, 'msg' => ['Your account has been Deactivate']]);
                    }
                    else{
                        return response()->json(['status' => true, 'msg' => ['Success']]);
                    }  
                    
                } else {
                    return response()->json(['status' => false, 'msg' => ['User does not exist.']]);
                }
            } else {
                // dd($row[]);
                return response()->json(['status' => false, 'msg' => ['User not found']]);
            }
        }
    }  
}
