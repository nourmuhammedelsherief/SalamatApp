<?php

namespace App\Http\Controllers\Api;

use App\CarType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App;
use Auth;
use App\User;
use App\City;
use App\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmCode;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function registerMobile(Request $request) {
        $rules = [
            'phone_number' => 'required|unique:users',
//            'phone_number' => 'required|max:9|unique:users|regex:/(5)[0-9]{8}/',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $code = mt_rand(1000, 9999);
            $jsonObj = array(
            'mobile' => 'salamat',
            'password' => 'a102030',
            'sender'=>'salamat',
            'numbers' => $request->phone_number,
            'msg'=>'كود التأكيد الخاص بك في سلامات هو :'.$code,

            'msgId' => rand(1,99999),

            'timeSend' => '0',

            'dateSend' => '0',

            'deleteKey' => '55348',
            	'lang' => '3',
            	'applicationType' => 68,
            );
            // دالة الإرسال JOSN
            $result=$this->sendSMS($jsonObj);


//        $ans= substr($ans,0,1);
        $created = App\PhoneVerification::create([
            'code'=>$code,
            'phone_number'=>$request->phone_number
        ]);


        return  ApiController::respondWithSuccess([]);


    }
  public  function sendSMS($jsonObj)
{
    $contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/json', 'content'=> json_encode($jsonObj), 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
    $contextResouce  = stream_context_create($contextOptions);
    $url = "http://www.alfa-cell.com/api/msgSend.php";
    $arrayResult = file($url, FILE_IGNORE_NEW_LINES, $contextResouce);
    $result = $arrayResult[0];

    return $result;
}
    public function register_phone_post(Request $request){

        $rules = [
            'code' => 'required',
            'phone_number' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= App\PhoneVerification::where('phone_number',$request->phone_number)->orderBy('id','desc')->first();

        if ($user){

            if($user->code == $request->code){
                $successLogin = ['key'=>'message',
                    'value'=> "كود التفعيل صحيح"
                ];
                return ApiController::respondWithSuccess($successLogin);
            }else{
                $errorsLogin = ['key'=>'message',
                    'value'=> trans('messages.error_code')
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }

        }else{

            $errorsLogin = ['key'=>'message',
                'value'=> trans('messages.error_code')
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }


    }
    public function resend_code(Request $request){

        $rules = [
            'phone_number' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));


        $code = mt_rand(1000, 9999);


    $jsonObj = array(
            'mobile' => 'salamat',
            'password' => 'a102030',
            'sender'=>'salamat',
            'numbers' => $request->phone_number,
            'msg'=>'كود التأكيد الخاص بك في سلامات هو :'.$code,

            'msgId' => rand(1,99999),

            'timeSend' => '0',

            'dateSend' => '0',

            'deleteKey' => '55348',
            	'lang' => '3',
            	'applicationType' => 68,
            );
            // دالة الإرسال JOSN
            $result=$this->sendSMS($jsonObj);

        $created = App\PhoneVerification::create([
            'code'=>$code,
            'phone_number'=>$request->phone_number
        ]);


            return $created
                ? ApiController::respondWithSuccess( trans('messages.success_send_code'))
                : ApiController::respondWithServerErrorObject();





    }

    public function register_data(){

        $nationalities = App\Nationality::select('id','name')->get();
        $data =[];
        array_push($data,['nationalities'=>$nationalities]);
        return ApiController::respondWithSuccess($data);

    }
    public function get_region($id){

        $cities = App\City::find($id);
        if ($cities == null){
            $errorsLogin = ['key'=>'message',
                'value'=> "لا يوجد"
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }

        $cities = App\City::select('id','name')->where('parent_id',$id)->get();


        return ApiController::respondWithSuccess($cities);

    }

    public function register(Request $request) {

        $rules = [
            'phone_number'          => 'required|unique:users',
            'name'                  => 'required|max:255',
//            'national_image'        => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
//            'car_image'             => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'device_token'          => 'required',
            'national_id'           => 'required',
            'car_number'            =>'required',
            'nationality_id'        =>'required',
//            'licence_image'         =>'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
        $all=[];

            $user = User::create([
                'phone_number'   => $request->phone_number,
                'name'           => $request->name,
                'active'         => 0,
                'national_id'    => $request->national_id,
                'password'       => Hash::make($request->password),
//                'image'          => $request->file('national_image') == null ? null : UploadImage($request->file('national_image'), 'image', '/uploads/users'),
//                'car_image'      => UploadImage($request->file('car_image'), 'image', '/uploads/cars'),
                'nationality_id' => $request->nationality_id,
                'car_number'     => $request->car_number,
                'type'           => 1,
//                'licence_image'  => $request->file('licence_image') == null ? null : UploadImage($request->file('licence_image'), 'image', '/uploads/licences'),


            ]);

            $user->update(['api_token' => generateApiToken($user->id, 10)]);

         App\PhoneVerification::where('phone_number',$request->phone_number)->orderBy('id','desc')->delete();
            array_push($all,[
                'id'              =>$user->id,
                'name'            =>$user->name,
                'phone_number'    =>$user->phone_number,
                'active'          =>$user->active,
                'national_id'     =>$request->national_id,
                'car_number'      =>$request->car_number,
                'api_token'       =>$user->api_token,
                'nationality_id'  =>intval($user->nationality_id),
                'nationality'     => App\Nationality::find($user->nationality_id)->name,
                'rate'=>(int) App\Rate::where('to_user_id',$user->id)->avg('rate'),
                'created_at'     =>$user->created_at->format('Y-m-d'),
            ]);


        //save_device_token....
        $created = ApiController::createUserDeviceToken($user->id, $request->device_token, $request->device_type);

        return $user
            ? ApiController::respondWithSuccess($all)
            : ApiController::respondWithServerErrorArray();

    }


    public function login(Request $request) {

        $rules = [
            'phone_number'  => 'required',
            'password'      => 'required',
            'device_token'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));


            if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password, 'type'=>1])) {

                if (Auth::user()->active == 0){
                    $errors = ['key'=>'message',
                        'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
                    ];
                    return ApiController::respondWithErrorArray(array($errors));
                }

                //save_device_token....
                $created = ApiController::createUserDeviceToken(Auth::user()->id, $request->device_token, $request->device_type);

                $all = User::where('phone_number', $request->phone_number)->first();
                $all->update(['api_token' => generateApiToken($all->id, 10)]);
                $user =  User::where('phone_number', $request->phone_number)->first();

                $all=[];
                array_push($all,[
                    'id'              =>intval($user->id),
                    'name'            =>$user->name,
                    'phone_number'    =>$user->phone_number,
                    'active'          =>$user->active,
                    'service_type'    =>intval($user->service_type),
                    'other'           =>intval($user->other),
                    'car_type'        =>intval($user->car_type),
                    'car_type_name'   =>CarType::find($user->car_type)->name,
                    'national_image'  => 'http://salamat.tqnee.com/uploads/national_images/'.$user->image,
                    'car_image'       => 'http://salamat.tqnee.com/uploads/car_images/'.$user->car_image,
                    'licence_image'   => 'http://salamat.tqnee.com/uploads/licence_images/'.$user->licence_image,
                    'id_image'        => 'http://salamat.tqnee.com/uploads/id_images/'.$user->id_image,
                    'paper_image'     => 'http://salamat.tqnee.com/uploads/paper_images/'.$user->paper_image,
                    'national_id'     =>$user->national_id,
                    'car_number'      =>$user->car_number,
                    'api_token'       =>$user->api_token,
                    'nationality_id'  =>intval($user->nationality_id),
                    'nationality'     => App\Nationality::find($user->nationality_id)->name,
                    'rate'            =>(int) App\Rate::where('to_user_id',$user->id)->avg('rate'),
                    'created_at'      =>$user->created_at->format('Y-m-d'),
                ]);


                return $created
                    ? ApiController::respondWithSuccess($all)
                    : ApiController::respondWithServerErrorArray();
            }else{
                $errors = [
                    'key'=>'message',
                    'value'=>trans('messages.Wrong_credential'),
                ];
                return ApiController::respondWithErrorNOTFoundArray(array($errors));
            }







    }
    public function forgetPassword(Request $request) {
        $rules = [
            'phone_number' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user = User::where('phone_number',$request->phone_number)->first();

        if($user) {
            $code = mt_rand(1000, 9999);


                   $jsonObj = array(
            'mobile' => 'salamat',
            'password' => 'a102030',
            'sender'=>'salamat',
            'numbers' => $request->phone_number,
            'msg'=>'كود التأكيد الخاص بك في سلامات هو :'.$code,

            'msgId' => rand(1,99999),

            'timeSend' => '0',

            'dateSend' => '0',

            'deleteKey' => '55348',
            	'lang' => '3',
            	'applicationType' => 68,
            );
            // دالة الإرسال JOSN
            $result=$this->sendSMS($jsonObj);
            $updated=  User::where('phone_number',$request->phone_number)->update([
                'verification_code'=>$code,
            ]);
            $success = ['key'=>'message',
                'value'=> "تم ارسال الكود بنجاح"
            ];

                return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();




        }
        $errorsLogin = ['key'=>'message',
            'value'=> trans('messages.Wrong_phone')
        ];
        return ApiController::respondWithErrorClient(array($errorsLogin));
    }
    public function confirmResetCode(Request $request){

        $rules = [
            'phone_number' => 'required',
            'code' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= User::where('phone_number',$request->phone_number)->where('verification_code',$request->code)->first();
        if ($user){
            $updated=  User::where('phone_number',$request->phone_number)->where('verification_code',$request->code)->update([
                'verification_code'=>null
            ]);
            $success = ['key'=>'message',
                'value'=> "الكود صحيح"
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();
        }else{

            $errorsLogin = ['key'=>'message',
                'value'=> trans('messages.error_code')
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }


    }

    public function resetPassword(Request $request) {
        $rules = [
            'phone_number'                 => 'required|numeric',
//            'phone'                 => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user = User::where('phone_number',$request->phone_number)->first();
//        $user = User::wherePhone($request->phone)->first();

        if($user)
            $updated = $user->update(['password' => Hash::make($request->password)]);
        else{
            $errorsLogin = ['key'=>'message',
                'value'=> trans('messages.Wrong_phone')
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }


        return $updated
            ? ApiController::respondWithSuccess(trans('messages.Password_reset_successfully'))
            : ApiController::respondWithServerErrorObject();
    }

    public function changePassword(Request $request) {

        $rules = [
            'current_password'      => 'required',
            'new_password'          => 'required',
            'password_confirmation' => 'required|same:new_password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $error_old_password = ['key'=>'message',
            'value'=> trans('messages.error_old_password')
        ];
        if (!(Hash::check($request->current_password, $request->user()->password)))
                return ApiController::respondWithErrorNOTFoundObject(array($error_old_password));
//        if( strcmp($request->current_password, $request->new_password) == 0 )
//            return response()->json(['status' => 'error', 'code' => 404, 'message' => 'New password cant be the same as the old one.']);

        //update-password-finally ^^
        $updated = $request->user()->update(['password' => Hash::make($request->new_password)]);

        $success_password = ['key'=>'message',
            'value'=> trans('messages.Password_reset_successfully')
        ];

        return $updated
            ? ApiController::respondWithSuccess($success_password)
            : ApiController::respondWithServerErrorObject();
    }

    public function change_phone_number(Request $request) {


        $rules = [
            'phone_number' => 'required|numeric|unique:users,phone_number,'.$request->user()->id,

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));



            $code = mt_rand(1000, 9999);


                   $jsonObj = array(
            'mobile' => 'salamat',
            'password' => 'a102030',
            'sender'=>'salamat',
            'numbers' => $request->phone_number,
            'msg'=>'كود التأكيد الخاص بك في سلامات هو :'.$code,

            'msgId' => rand(1,99999),

            'timeSend' => '0',

            'dateSend' => '0',

            'deleteKey' => '55348',
            	'lang' => '3',
            	'applicationType' => 68,
            );
            // دالة الإرسال JOSN
            $result=$this->sendSMS($jsonObj);
            $updated=  User::where('id',$request->user()->id)->update([
                'verification_code'=>$code,
            ]);

        $success = ['key'=>'message',
            'value'=> trans('messages.success_send_code')
        ];
        return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();




    }
    public function check_code_changeNumber(Request $request){

        $rules = [
            'code' => 'required',
            'phone_number' => 'required|numeric|unique:users,phone_number,'.$request->user()->id,
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= User::where('id',$request->user()->id)->where('verification_code', $request->code)->first();
        if ($user){
            $updated=  $user->update([
                'verification_code'=>null,
                'phone_number'=>$request->phone_number,
            ]);

            $success = ['key'=>'message',
                'value'=> "success your phone number changed"
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();
        }else{

            $errorsLogin = ['key'=>'message',
                'value'=> trans('messages.error_code')
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }


    }

    public function logout(Request $request)
    {

        $rules = [
            'device_token'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $exists = App\UserDevice::where('id',$request->user()->id)->where('device_token',$request->device_token)->get();

        if (count($exists) !== 0){
            foreach ($exists  as $new){
                $new->delete();
            }

        }
        $users=  User::where('id',$request->user()->id)->first()->update(
            [
                'api_token'=>null
            ]
        );
        return $users
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();


    }
    public function online(Request $request)
    {
        $rules = [
            'is_online'     => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $user= User::where('id',$request->user()->id)->first();
        if ($user){
            $updated=  $user->update([
                'status'     => $request->is_online,
            ]);

            $success = ['key'=>'message',
                'value'=> "success your status changed"
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();
        }else{

            $errorsLogin = ['key'=>'message',
                'value'=> "حالتك  لم  تتغير"
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }


    }
    public function change_car_number(Request $request) {


        $rules = [
            'car_number' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        if (Auth::user()->active == 0){
            $errors = ['key'=>'message',
                'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $updated=  User::where('id',$request->user()->id)->update([
            'car_number'=>$request->car_number,
            'active'    =>0,
        ]);

        $success = ['key'=>'message',
            'value'=> 'تم تغيير رقم لوحه الساطحه بنجاح'
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();

    }

    public function change_car_image(Request $request) {


        $rules = [
            'car_image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        if (Auth::user()->active == 0){
            $errors = ['key'=>'message',
                'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $user = User::where('id',$request->user()->id)->first();
        $updated=  User::where('id',$request->user()->id)->update([
            'car_image'    => $request->file('car_image') == null ? $user->car_image : UploadImage($request->file('car_image'), 'image', '/uploads/car_images'),
            'active'    =>0,
        ]);

        $success = ['key'=>'car_image',
            'value'=> "http://salamat.tqnee.com/uploads/car_images/".User::find($request->user()->id)->car_image
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();

    }
    public function change_licence_image(Request $request) {


        $rules = [
            'licence_image'         =>'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        if (Auth::user()->active == 0){
            $errors = ['key'=>'message',
                'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $user = User::where('id',$request->user()->id);
        $updated=  User::where('id',$request->user()->id)->update([
            'licence_image'   => $request->file('licence_image') == null ? $user->licence_image : UploadImage($request->file('licence_image'), 'image', '/uploads/licence_images'),
            'active'    =>0,
        ]);

        $success = ['key'=>'message',
            'value'=> "http://salamat.tqnee.com/uploads/licence_images/".User::find($request->user()->id)->licence_image
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();

    }
    /**
     *  @change_paper_image
    */
    public function change_paper_image(Request $request)
    {
        $rules = [
            'paper_image'     =>'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        if (Auth::user()->active == 0){
            $errors = ['key'=>'message',
                'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $user = User::where('id',$request->user()->id)->first();
        $updated=  User::where('id',$request->user()->id)->update([
            'paper_image'   => $request->file('paper_image') == null ? $user->paper_image : UploadImage($request->file('paper_image'), 'image', '/uploads/paper_images'),
         ]);

        $success = ['key'=>'message',
            'value'=> "http://salamat.tqnee.com/uploads/paper_images/".User::find($request->user()->id)->paper_image
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }
    /**
     * @change_id_image
    */
    public function change_id_image(Request $request)
    {
        $rules = [
            'id_image'     =>'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
        if (Auth::user()->active == 0){
            $errors = ['key'=>'message',
                'value'=> trans('messages.Sorry_your_membership_was_stopped_by_Management')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $user = User::where('id',$request->user()->id)->first();
        $updated=  User::where('id',$request->user()->id)->update([
            'id_image'  => $request->file('id_image') == null ? $user->id_image : UploadImage($request->file('id_image'), 'image', '/uploads/id_images'),
         ]);

        $success = ['key'=>'message',
            'value'=> "http://salamat.tqnee.com/uploads/id_images/".User::find($request->user()->id)->id_image
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }

}
