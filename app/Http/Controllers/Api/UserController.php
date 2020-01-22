<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Validator;
use App\User;
use App\CarType;
use App;
use Auth;

class UserController extends Controller
{
    //
    public function change_image(Request $request){

        $rules = [
            'national_image'            => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= User::where('id',$request->user()->id)->first();

            $updated=  $user->update([
                'image'          => $request->file('national_image') == null ? null : UploadImage($request->file('national_image'), 'image', '/uploads/national_images'),
            ]);

            $success = ['key'=>'image',
                'value'=> "http://salamat.tqnee.com/uploads/national_images/".User::find($request->user()->id)->image
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();



    }
    /**
     * @change_car_type
    */
    public function change_car_type(Request $request){

        $rules = [
            'car_type'            => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= User::where('id',$request->user()->id)->first();

            $updated=  $user->update([
                'car_type'           => $request->car_type,
            ]);

            $success = ['key'=>'car_type',
                'value'=> "تم  تغيير نوع السيارة بنجاح"
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();



    }
    /**
     * @change_services
    */
    public function change_services(Request $request){

        $rules = [
            'service_type'   => 'nullable',
            'other'          => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user= User::where('id',$request->user()->id)->first();

            $updated=  $user->update([
                'service_type'   => $request->service_type == null ? '0' :$request->service_type,
                'other'           => $request->other == null ? '0' :$request->other,
            ]);

            $success = ['key'=>'car_type',
                'value'=> "تم  تغيير خدمات السيارة بنجاح"
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();



    }

    public function all_contacts(Request $request)
    {
        $contacts = App\Contact::orderBy('created_at' , 'desc')->get();
        $count= $contacts->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $contacts->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $contact)
        {
            array_push($all,[
                'id'=>intval($contact->id),
                'name'=>$contact->name,
                'photo'=>'http://salamat.tqnee.com/uploads/contacts_photos/'.$contact->photo,
                'phone'=>$contact->phone,
                'created_at'=>$contact->created_at->format('Y-m-d')
            ]);

        }
        $data=[];
        array_push($data , ['contacts'=> $all , 'count'=> $count]);

        return ApiController::respondWithSuccess($data);
    }
    public function call_center(Request $request)
    {
        $call_center = App\CallCenter::orderBy('created_at' , 'desc')->first();
        $all=[];

            array_push($all,[
                'id'=>intval($call_center->id),
                'name'=>$call_center->name,
                'photo'=>'http://salamat.tqnee.com/uploads/call_center/'.$call_center->photo,
                'phone'=>$call_center->phone,
                'created_at'=>$call_center->created_at->format('Y-m-d')
            ]);
        $data=[];
        array_push($data , ['call_center'=> $all]);
        return ApiController::respondWithSuccess($data);
    }
    public function all_news(Request $request)
    {
        $news = App\News::orderBy('created_at' , 'desc')->get();
        $count= $news->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $news->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $new)
        {
            array_push($all,[
                'id'=>intval($new->id),
                'user_name'=>$new->user_name,
                'user_photo'=>'http://salamat.tqnee.com/uploads/users/'.$new->user_photo,
                'title'=>$new->title,
                'news_photo'=>'http://salamat.tqnee.com/uploads/news_photos/'.$new->news_photo,
                'content' => $new->content,
                'created_at'=>$new->created_at->format('Y-m-d')
            ]);

        }
        $data=[];
        array_push($data , ['news'=> $all , 'count'=> $count]);

        return ApiController::respondWithSuccess($data);
    }
    public function get_news_by_id(Request $request , $news_id)
    {
        $news = App\News::find($news_id);
        $all=[];
        if ($news == null)
        {
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }else{
            array_push($all,[
                'id'=>intval($news->id),
                'user_name'=>$news->user_name,
                'user_photo'=>'http://salamat.tqnee.com/uploads/users/'.$news->user_photo,
                'title'=>$news->title,
                'news_photo'=>'http://salamat.tqnee.com/uploads/news_photos/'.$news->news_photo,
                'content' => $news->content,
                'created_at'=>$news->created_at->format('Y-m-d')
            ]);
        }


        $data=[];
        array_push($data , ['news'=> $all]);

        return ApiController::respondWithSuccess($data);
    }
    public function car_types(Request $request)
    {
        $car_types = App\CarType::orderBy('created_at' , 'desc')->get();
        $count= $car_types->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $car_types->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $car_type)
        {
            array_push($all,[
                'id'=>intval($car_type->id),
                'type'=>$car_type->name,
                'created_at'=>$car_type->created_at->format('Y-m-d')
            ]);

        }
        $data=[];
        array_push($data , ['car_types'=> $all , 'count'=> $count]);

        return ApiController::respondWithSuccess($data);
    }
    public function complete_register(Request $request)
    {
        $rules = [
            'service_type'          => 'nullable',
            'other'                 => 'nullable',
            'car_type'              => 'required',
            'national_image'        => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'car_image'             => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'licence_image'         => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'id_image'              => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'paper_image'           => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
        $all=[];
        // find selected user
        $user = User::find($request->user()->id);
        if($user != null){
            $user->update([
                'service_type'   => $request->service_type == null ? '0' :$request->service_type,
                'other'           => $request->other == null ? '0' :$request->other,
                'car_type'           => $request->car_type,
                'image'          => $request->file('national_image') == null ? null : UploadImage($request->file('national_image'), 'image', '/uploads/national_images'),
                'car_image'          => $request->file('car_image') == null ? null : UploadImage($request->file('car_image'), 'image', '/uploads/car_images'),
                'licence_image'          => $request->file('licence_image') == null ? null : UploadImage($request->file('licence_image'), 'image', '/uploads/licence_images'),
                'id_image'          => $request->file('id_image') == null ? null : UploadImage($request->file('id_image'), 'image', '/uploads/id_images'),
                'paper_image'          => $request->file('paper_image') == null ? null : UploadImage($request->file('paper_image'), 'image', '/uploads/paper_images'),
            ]);

//        $user->update(['api_token' => generateApiToken($user->id, 10)]);
//
//        App\PhoneVerification::where('phone_number',$request->phone_number)->orderBy('id','desc')->delete();
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


            //save_device_token....
//        $created = ApiController::createUserDeviceToken($user->id, $request->device_token, $request->device_type);

            return $user
                ? ApiController::respondWithSuccess($all)
                : ApiController::respondWithServerErrorArray();
        }


    }
}
