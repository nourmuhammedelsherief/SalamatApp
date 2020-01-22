<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\UserDevice;
use App;
use Auth;
use Image;

class OrderController extends Controller
{
    //
    public function order_post(Request $request){

        $rules = [
            'start'          => 'required',// 1 for student 2 for employee 3 for rent
            'end'            =>'required',
            'current_lat'    =>'nullable',
            'current_long'   =>'nullable',
            'target_lat'     =>'nullable',
            'target_long'    =>'nullable',
            'service_type'   =>'required',
            'car_type'       =>'required',
            'car_status'     =>'required',
            'size'           =>'required',
            'car_photo'      =>'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
        $created = App\Order::create([
            'start'=>$request->start,
            'end'=>$request->end,
            'current_lat'=>$request->current_lat,
            'current_long'=>$request->current_long,
            'target_lat'=>$request->target_lat,
            'target_long'=>$request->target_long,
            'user_id'=>$request->user()->id,
            'service_type'=>$request->service_type,
            'car_type'=>$request->car_type,
            'car_status'=>$request->car_status,
            'size'=>$request->size,
            'car_photo'=> $request->file('car_photo') == null ? null : UploadImage($request->file('car_photo'), 'image', '/uploads/car_photos'),
        ]);
        $users = App\User::whereType('1')->get();
        foreach ($users as $user)
        {
            App\OrderForSawaq::create([
                'order_id'=>$created->id,
                'user_id'=>$user->id,
                'status'=>1,

            ]);
        }
        $data=[
            'id'=>intval($created->id),
            'user_id'=>intval($request->user()->id),
            'phone_number'=>User::find($request->user()->id)->phone_number,
            'username'=>User::find($request->user()->id)->name,
            'start'=>$created->start,
            'end'=>$created->end,
            'current_lat'=>$created->current_lat,
            'current_long'=>$created->current_long,
            'target_lat'=>$created->target_lat,
            'target_long'=>$created->target_long,
            'service_type'=>intval($created->service_type),
            'car_type'=>$created->car_type,
            'car_status'=>$created->car_status,
            'size'=>$created->size,
            'car_photo'=>'http://salamat.tqnee.com/uploads/car_photos/'.$created->car_photo,
            'status'=>0,
            'sawaq_user_id'=>null,
            'price'=>null,
            'created_at'=>$created->created_at->format('Y-m-d'),

        ];
        $users = App\User::whereActive('1')
            ->where('status'  , '1')
            ->where('type' , '1')
            ->get();
        foreach ($users as $user)
        {
            $devicesTokens =  App\UserDevice::where('user_id',$user->id)
                ->get()
                ->pluck('device_token')
                ->toArray();
            if ($devicesTokens) {
                sendMultiNotification("طلب جديد", "افحص هذا الطلب " ,$devicesTokens);
            }

            saveNotification($user->id, "طلب جديد" , '1', "افحص هذا الطلب" , $user->id , $request->user()->id);
        }
        return $created
            ? ApiController::respondWithSuccess(array($data))
            : ApiController::respondWithServerErrorArray();
    }
    public function accept_sawaq_offers_price($id,Request $request){
        $offer=App\SawaqOfferPrice::find($id);
        if ($offer == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorObject(array($errors));
        }else{
            $offer->update(
                ['commission_status'=>'0']
            );
            $order = App\Order::where('id',$offer->order_id)->first();
            $end = Carbon::now();
            $order = App\Order::where('id',$offer->order_id)
                ->first()->update([
                    'status'        =>'1', //for done deal
                    'sawaq_user_id' =>$offer->sawaq_user_id,
                    'price'         =>$offer->price,
                    'end_at'        =>$end,
                ]);
//            $ordered = App\Order::where('id',$offer->order_id)
//                ->first();
//            if ($ordered->end_at < Carbon::now())
//            {
//                $order = App\Order::where('id',$offer->order_id)
//                    ->first()->update([
//                        'status'        =>'2', //for done deal
//                        'sawaq_user_id' =>$offer->sawaq_user_id,
//                        'price'         =>$offer->price,
//                    ]);
//            }



            $devicesTokens = App\UserDevice::where('user_id', $offer->sawaq_user_id)
                ->get()
                ->pluck('device_token')
                ->toArray();

            if ($devicesTokens) {
                sendMultiNotification("العروض", "لقد تم قبول عرضك" ,$devicesTokens);
            }

            saveNotification($offer->sawaq_user_id, "العروض" , '1', "لقد تم قبول عرضك" , $offer->order_id ,null);

            $my0rder= App\Order::where('id',$offer->order_id)->first();
            $end = Carbon::now()->addHours(3);
            $all_offers=App\SawaqOfferPrice::where('id','=', $id)->first()->update(['end_date'=>$end->format('Y-m-d')]);
            $all_offers=App\SawaqOfferPrice::where('id','!=', $id)->get();
            foreach ($all_offers as $data){

                $data->delete();

            }


            App\OrderForSawaq::where('order_id',$offer->order_id)->where('user_id','=', $offer->sawaq_user_id)->first()->update(['status'=>2]);
//        App\Order::where('id',$offer->order_id)->where('user_id','=', $offer->user_id)->first()->update(['status'=>3]);


            $all_data=[
                'phone_number'=>User::find($request->user()->id)->phone_number,
                'username'=>User::find($request->user()->id)->name,
                'status'=>$my0rder->status,
                'sawaq_user_id'=>$my0rder->sawaq_user_id,
                'price'=>$my0rder->price,
                'id'=>intval($my0rder->id),
                'user_id'=>$my0rder->user_id,
                'start'=>$my0rder->start,
                'end'=>$my0rder->end,
                'current_lat'=>$my0rder->current_lat,
                'current_long'=>$my0rder->current_long,
                'target_lat'=>$my0rder->target_lat,
                'target_long'=>$my0rder->target_long,
                'created_at'=>$my0rder->created_at->format('Y-m-d'),



            ];




            return $order
                ? ApiController::respondWithSuccess($all_data)
                : ApiController::respondWithServerErrorObject();
        }

//
    }
    public function user_cancel_order(Request $request , $id)
    {
        $order = App\Order::find($id);
        if ($order == null)
        {
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorObject(array($errors));
        }else
        {
            $order->update([
                'status'=>'2',
            ]);
            $success = ['key'=>'Order',
                'Message'=> 'تم الغاء طلبك بنجاح'
            ];
            return $order
                ? ApiController::respondWithSuccess($success)
                : ApiController::respondWithServerErrorObject();
        }
    }
    /**/
    public function delete_sawaq_offers_price($id,Request $request){

        $offer=App\SawaqOfferPrice::find($id);
        $order = App\Order::find($offer->order_id);

        $devicesTokens = App\UserDevice::where('user_id', $offer->sawaq_user_id)
            ->get()
            ->pluck('device_token')
            ->toArray();

        if ($devicesTokens) {
            sendMultiNotification("العروض", "لقد تم رفض عرضك"   ,$devicesTokens);
        }
        saveNotification($offer->sawaq_user_id, "العروض" , '1', "لقد تم رفض عرضك");

        $offer->delete();

        return $offer
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();
    }
    public function allOrders()
    {
        $orders = App\Order::where('status' , '0')->get();
        foreach ($orders as $created)
        {
            $data=[
                'id'=>intval($created->id),
                'user_id'=>intval($created->user_id),
                'phone_number'=>User::find($created->user_id)->phone_number,
                'username'=>User::find($created->user_id)->name,
                'start'=>$created->start,
                'end'=>$created->end,
                'current_lat'=>$created->current_lat,
                'current_long'=>$created->current_long,
                'target_lat'=>$created->target_lat,
                'target_long'=>$created->target_long,
                'service_type'=>intval($created->service_type),
                'car_type'=>$created->car_type,
                'car_status'=>$created->car_status,
                'size'=>$created->size,
                'car_photo'=>'http://salamat.tqnee.com/uploads/car_photos/'.$created->car_photo,
                'status'=>0,
                'sawaq_user_id'=>null,
                'price'=>null,
                'created_at'=>$created->created_at->format('Y-m-d'),

            ];
        }

        return $orders
            ? ApiController::respondWithSuccess(array($data))
            : ApiController::respondWithServerErrorArray();
    }
    public function sawaq_order_1_2(Request $request)
    {
        $orders = App\Order::where('status' , '1')
            ->orWhere('status' , '2')
            ->get();
        $count= $orders->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $orders->slice(($currentPage - 1) * $perPage, $perPage);
        $new =[];
        foreach ($currentPageItems1 as $offer)
        {
            if ($offer->user_id != null)
            {
                array_push($new,[
                    'id'=>intval($offer->id),
                    'status'=>intval($offer->status),
                    'commission_status'=>App\SawaqOfferPrice::where('order_id',$offer->id)->where('sawaq_user_id',$request->user()->id)->first() == null ? null : App\SawaqOfferPrice::where('order_id',$offer->id)->where('sawaq_user_id',$request->user()->id)->first()->commission_status ,
                    'price'=>$offer->price,
                    'sawaq_user_id'=>$offer->sawaq_user_id,
                    'user_id'=>$offer->user_id,
                    'created_at'=>$offer->created_at->format('Y-m-d'),
                    'phone_number'=>User::find($offer->user_id)->phone_number,
                    'username'=>User::find($offer->user_id)->name,
                    'start'=>$offer->start,
                    'end'=>$offer->end,
                    'current_lat'=>$offer->current_lat,
                    'current_long'=>$offer->current_long,
                    'target_lat'=>$offer->target_lat,
                    'target_long'=>$offer->target_long,
                    'service_type'=>intval($offer->service_type),
                    'car_type'=>$offer->car_type,
                    'car_status'=>$offer->car_status,
                    'size'=>$offer->size,
                    'car_photo'=>'http://salamat.tqnee.com/uploads/car_photos/'.$offer->car_photo,
                ]);
            }
        }
        $data=[];
        array_push($data , ['orders'=> $new , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }

    public function sawaq_all_offers_orders(Request $request)
    {
        $orders = App\SawaqOrder::whereSawaq_id($request->user()->id)->get();
        if ($orders == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }

        $count= $orders->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $orders->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($orders as $offer)
        {
            array_push($all,[
                'id'=>intval($offer->id),
                'order_id'=>App\Order::find($offer->order_id)
            ]);

        }
        $data=[];
        array_push($data , ['orders'=> $all , 'count'=> $count]);

        return ApiController::respondWithSuccess($data);
    }

}
