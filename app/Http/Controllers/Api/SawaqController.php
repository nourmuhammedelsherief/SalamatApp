<?php

namespace App\Http\Controllers\Api;

use App\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;
use App\User;
use App;
use Auth;

class SawaqController extends Controller
{
    //


    public function my_orders(Request $request)
    {
//        $orders = App\Order::whereStatus('0')->get();
        $orders = App\OrderForSawaq::where('order_for_sawaq.user_id',$request->user()->id)
            ->join('orders','orders.id','=','order_for_sawaq.order_id')
            ->select('order_for_sawaq.id as sawaq_id','order_for_sawaq.status as sawaq_status','order_for_sawaq.order_id as order_id'
                ,'orders.*')
            ->where('order_for_sawaq.status',$request->status == null ? 1 : $request->status )
            ->get();

//        return ApiController::respondWithSuccess($orders);
        $count= $orders->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $orders->slice(($currentPage - 1) * $perPage, $perPage);
        $new =[];
        foreach($currentPageItems1 as $data){
            if($data->user_id != null)
            {
                array_push($new,[
                    'id'=>intval($data->id),
                    'commission_status'=>App\SawaqOfferPrice::where('order_id',$data->id)->where('sawaq_user_id',$request->user()->id)->first() == null ? null : App\SawaqOfferPrice::where('order_id',$data->id)->where('sawaq_user_id',$request->user()->id)->first()->commission_status ,
                    'user_id'=>$data->user_id,
                    'status'=>intval($data->status),
                    'start'=>$data->start,
                    'end'=>$data->end,
                    'current_lat'=>$data->current_lat,
                    'current_long'=>$data->current_long,
                    'target_lat'=>$data->target_lat,
                    'target_long'=>$data->target_long,
                    'service_type'=>intval($data->service_type),
                    'car_type'=>$data->car_type,
                    'car_status'=>$data->car_status,
                    'size'=>$data->size,
                    'car_photo'=>'http://salamat.tqnee.com/uploads/car_photos/'.$data->car_photo,
                    'created_at'=>$data->created_at->format('Y-m-d'),
                    'price'=>$data->price,
                    'sawaq_user_id'=>$data->sawaq_user_id,
                    'phone_number'=>User::find($request->user()->id)->phone_number,
                    'username'=>User::find($request->user()->id)->name,
                ]);
            }



        }
        $data=[];
        array_push($data , ['orders'=> $new , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }
    public function sawaq_waiting_order(Request $request)
    {


//        $orders = App\Order::whereStatus('0')->get();
        $orders = App\OrderForSawaq::where('order_for_sawaq.user_id',$request->user()->id)
            ->join('orders','orders.id','=','order_for_sawaq.order_id')
            ->select('order_for_sawaq.id as sawaq_id','order_for_sawaq.status as sawaq_status','order_for_sawaq.order_id as order_id'
                ,'orders.*')
            ->where('order_for_sawaq.status',$request->status == null ? 2 : $request->status )
            ->get();

//        return ApiController::respondWithSuccess($orders);
        $count= $orders->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $orders->slice(($currentPage - 1) * $perPage, $perPage);
        $new =[];
        foreach($currentPageItems1 as $data){

            array_push($new,[
                'id'=>intval($data->id),
                'commission_status'=>App\SawaqOfferPrice::where('order_id',$data->id)->where('sawaq_user_id',$request->user()->id)->first() == null ? null : App\SawaqOfferPrice::where('order_id',$data->id)->where('sawaq_user_id',$request->user()->id)->first()->commission_status ,
                'user_id'=>App\User::find($data->user_id)->id,
                'status'=>intval($data->status),
                'start'=>$data->start,
                'end'=>$data->end,
                'current_lat'=>$data->current_lat,
                'current_long'=>$data->current_long,
                'target_lat'=>$data->target_lat,
                'target_long'=>$data->target_long,
                'created_at'=>$data->created_at->format('Y-m-d'),
                'price'=>$data->price,
                'sawaq_user_id'=>$data->sawaq_user_id,
                'phone_number'=>User::find($request->user()->id)->phone_number,
                'username'=>User::find($request->user()->id)->name,
                'service_type'=>intval($data->service_type),
                'car_type'=>$data->car_type,
                'car_status'=>$data->car_status,
                'size'=>$data->size,
                'car_photo'=>'http://salamat.tqnee.com/uploads/car_photos/'.$data->car_photo,
            ]);


        }
        $data=[];
        array_push($data , ['orders'=> $new , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }

    public function refuse_order(Request $request,$order_id)
    {
        $orders=App\OrderForSawaq::where('order_id',$order_id)
            ->where('user_id',$request->user()->id)->first();
        if ($orders == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }

        $orders=App\OrderForSawaq::where('order_id',$order_id)
            ->where('user_id',$request->user()->id)
            ->delete();

        return $orders
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();

    }
    public function send_offer($order_id,Request $request)
    {
        $order=App\Order::find($order_id);
        if ($order == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $rules = [
            'price' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $offer=App\SawaqOfferPrice::updateOrCreate(
            ['sawaq_user_id' => $request->user()->id, 'order_id' => $order->id,'user_id'=>App\Order::find($order->id)->user_id],
            [ 'price' => $request->price,'status'=>1]
        );
//        $created = App\SawaqOrder::create([
//            'order_id'=>$order_id,
//            'sawaq_id'=>$request->user()->id,
//        ]);
        $sawaqOrder = App\OrderForSawaq::updateOrCreate(
                ['order_id'=>$order_id , 'user_id'=>$request->user()->id],
                ['status'=>2]
        );

        $devicesTokens =  App\UserDevice::where('user_id',App\Order::find($order->id)->user_id)
            ->get()
            ->pluck('device_token')
            ->toArray();


        if ($devicesTokens) {
            sendMultiNotification("طلب جديد", "هناك سواق تقدم علي طلبك تصفح العرض" ,$devicesTokens);

        }

        saveNotification(App\Order::find($order->id)->user_id, "طلب جديد" , '1', "هناك سواق تقدم علي طلبك تصفح العرض" , $order->order_id , $request->user()->id);

        return $offer
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();

    }

    public function commission_status(Request $request){
        $commission = App\SawaqOfferPrice::where('sawaq_user_id',$request->user()->id)
            ->where('commission_status','!=',1)->get();
        if (count($commission) !== 0){
            $success = ['key'=>'message',
                'value'=> 2 // should pay commission
            ];

            return ApiController::respondWithSuccess($success);
        }else{
            $success = ['key'=>'message',
                'value'=> 1
            ];

            return ApiController::respondWithSuccess($success);
        }
    }
    public function get_driver($id,Request $request)
    {

        $user=App\User::find($id);
        if ($user == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $all=[];
        array_push($all,[
            'id'=>$user->id,
            'name'=>$user->name,
            'phone_number'=>$user->phone_number,
            'active'=>$user->active,
            'ImgPath'=>"/uploads/users/",
            'image'            => 'http://salamat.tqnee.com/uploads/national_images/'.$user->image,
            'car_image'            => $user->car_image,
            'licence_image'         =>$user->licence_image,
            'car_number'            => $user->car_number,
            'api_token'=>$user->api_token,
            'nationality_id' =>intval($user->nationality_id),
            'nationality' => App\Nationality::find($user->nationality_id)->name,
            'rate'=>(int) App\Rate::where('to_user_id',$user->id)->avg('rate'),
            'created_at'=>$user->created_at->format('Y-m-d'),
        ]);

        return $user
            ? ApiController::respondWithSuccess($all)
            : ApiController::respondWithServerErrorArray();

    }

    public function get_user($id,Request $request)
    {

        $user=App\User::find($id);
        if ($user == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $all=[];
        array_push($all,[
            'id'=>$user->id,
            'name'=>$user->name,
            'phone_number'=>$user->phone_number,
            'car_number'=>$user->car_number,
            'active'=>$user->active,
            'ImgPath'=>"/uploads/users/",
            'image'            => $user->image,
            'api_token'=>$user->api_token,
            'created_at'=>$user->created_at->format('Y-m-d'),
        ]);

        return $user
            ? ApiController::respondWithSuccess($all)
            : ApiController::respondWithServerErrorArray();

    }
    public function pay_commission($id,Request $request){

        $rules = [
            'image'            => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        // $user=   App\SawaqOfferPrice::find($id);

            $offer= App\SawaqOfferPrice::where('order_id',$id)->where('sawaq_user_id',$request->user()->id)->first();
        if ($offer == null){
            $errorsLogin = ['key'=>'message',
                'value'=> "لا يوجد"
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }else{

            $updated=  $offer->update([
                'commission'=>  UploadImageEdit($request->file('image'), 'image', '/uploads/users',$request->image),
            ]);


            $success = ['key'=>'image',
                'value'=> User::find($request->user()->id)->image
            ];
            return $updated
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();



        }
    }

}
