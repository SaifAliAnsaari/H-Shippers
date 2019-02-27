<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ParentController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use URL;
use DB;
use Auth;

class RegisterController extends ParentController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // $this->middleware('guest');
    // }

    protected $request;

    public function __contruct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
            'username' => ['required', 'string', 'max:100', 'unique:users']
        ]);
    }

    public function showRegistrationForm(){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        $employees = User::all();
        return view('auth.register', ['check_rights' => $this->check_employee_rights, 'employees' => $employees, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    // public function manage_employee(){
    //      parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
    //     return view('auth.register', ['check_rights' => $this->check_employee_rights]);
    // }

    public function EmployeesList(){
        echo json_encode(User::all());
    }

    public function UploadUserImage(Request $request){
        echo json_encode("HERE");die;
        // if($request->hasFile('employeePicture')){
        //     echo json_encode("FILE");die;
        // }
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $userPicture = '';
        if(isset($_FILES["employeePicture"])){
            $userPicture = './storage/employees/' . time().'-'.str_replace(' ', '_', basename($_FILES["employeePicture"]["name"]));
            move_uploaded_file($_FILES["employeePicture"]["tmp_name"], $userPicture);
        }
        if(is_null(User::whereEmail($data['email'])->first())){
            $status = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'home_num' => $data['home_phone'],
                'ice_num' => $data['ice_num'],
                'cnic' => $data['cnic'],
                'city' => $data['city'],
                'salary' => $data['salary'],
                'address' => $data['address'],
                'base_station' => $data['base_station'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'hiring' => $data['hiring'],
                'designation' => $data['designation'],
                'reporting_to' => $data['reporting'],
                'picture' => $userPicture  
            ]);
            if($status){
                // $save_notif = DB::table('notifications')->insert([
                //     'emp_id' => $status->id,
                //     'reporting_to' => $data['reporting'],
                //     'notif_status' => 'new emp'
                // ]);
                echo json_encode('success');
                die;
            }else{
                echo json_encode($status);
                die;
            }
        }else{
            echo json_encode('email_exist'); 
            die;
        }
    }

    public function edit_profile($id){
        parent::VerifyRights();
        parent::get_notif_data();
        if($this->redirectUrl){return redirect($this->redirectUrl);}
        if($id != Auth::id()){
            return redirect('/');
        }
        return view('includes.edit_profile', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    public function update_user_profile(Request $request){
        $employee = User::find($request->user_id);
        $hashedPassword = $employee->password;

        if (Hash::check($request->current_password, $hashedPassword)) {
            $employee->password = bcrypt($request->confirm_password);

            if($request->hasFile('employeePicture')){
                $completeFileName = $request->file('employeePicture')->getClientOriginalName();
                $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
                $extension = $request->file('employeePicture')->getClientOriginalExtension();
                $empPicture = str_replace(' ', '_', $fileNameOnly).'_'.time().'.'.$extension;
                $path = $request->file('employeePicture')->storeAs('public/employees', $empPicture);
                if(Storage::exists('public/employees/'.str_replace('./storage/employees/', '', $employee->picture))){
                    Storage::delete('public/employees/'.str_replace('./storage/employees/', '', $employee->picture));
                }
                $employee->picture = './storage/employees/'.$empPicture;
            }

            if($employee->save()){
                echo json_encode("success");
            }else{
                echo json_encode("failed");
            }
        }else{
            echo json_encode('not_match');
        }
    }
    
}
