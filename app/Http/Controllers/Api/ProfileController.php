<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;
use App\User;
use App;
use Auth;

class ProfileController extends Controller
{
    //

    public function about_us()
    {



        $about = App\AboutUs::first();
        $all=[
            'title'=>$about->title,
            'content'=>$about->content,
        ];


        return ApiController::respondWithSuccess($all);
    }
    public function terms_and_conditions()
    {



        $terms = App\TermsCondition::first();
        $all=[
            'title'=>$terms->title,
            'content'=>$terms->content,
        ];


        return ApiController::respondWithSuccess($all);
    }

    public function sawaq_offers_price(Request $request)
    {

        $offers = App\SawaqOfferPrice::where('user_id',$request->user()->id)->get();
        $count= $offers->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $offers->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $offer){
            array_push($all,[
                'id'=>$offer->id,
                'price'=>$offer->price,
                'order_id'=>$offer->order_id,
                'sawaq_user_id'=>$offer->sawaq_user_id,
                'username'=>User::find($offer->sawaq_user_id)->name,
                'created_at'=>$offer->created_at->format('Y-m-d') ,
            ]);
        }

        $data=[];
        array_push($data , ['offers'=> $all , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }
    public function my_order(Request $request)
    {

        $offers = App\Order::where('user_id',$request->user()->id)->get();
        $count= $offers->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $offers->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $offer){
            array_push($all,[
                'user_id'=>$request->user()->id,
                'status'=>$offer->status,
                'price'=>$offer->price,
                'sawaq_user_id'=>$offer->sawaq_user_id,
                'created_at'=>$offer->created_at->format('Y-m-d'),
                'phone_number'=>User::find($request->user()->id)->phone_number,
                'username'=>User::find($request->user()->id)->name,
                'start'=>$offer->start,
                'end'=>$offer->end,
                'current_lat'=>$offer->current_lat,
                'current_long'=>$offer->current_long,
                'target_lat'=>$offer->target_lat,
                'target_long'=>$offer->target_long,
            ]);

        }

        $data=[];
        array_push($data , ['orders'=> $all , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }


    public function order_details(Request $request)
    {
        $offers = App\Order::whereUser_id($request->user()->id)->get();
        if ($offers == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }else
        {
            $offersss = App\Order::whereUser_id($request->user()->id)
                ->where('price' , '!=' , null)
                ->where('sawaq_user_id' , '!=' , null)
                ->get();

        $count= $offers->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $offers->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        $offerss = App\Order::whereUser_id($request->user()->id)->get();
        foreach ($currentPageItems1 as $offer)
        {
            array_push($all,[
                'id'=>intval($offer->id),
                'status'=>intval($offer->status),
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
        $data=[];
        array_push($data , ['orders'=> $all , 'count'=> $count]);

        return ApiController::respondWithSuccess($data);
    }}
    public function order_offers($id , Request $request)
    {

        $offers = App\Order::find($id);
        if ($offers == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }

        $offers = App\SawaqOfferPrice::where('order_id',$id)->get();
        $count= $offers->count();
        $currentPage =$request->page;
        $perPage=10;
        $currentPageItems1 = $offers->slice(($currentPage - 1) * $perPage, $perPage);
        $all=[];
        foreach ($currentPageItems1 as $offer){
            array_push($all,[
                'id'=>$offer->id,
                'price'=>$offer->price,
                'order_id'=>$offer->order_id,
                'sawaq_user_id'=>$offer->sawaq_user_id,
                'username'=>User::find($offer->sawaq_user_id)->name,
                'created_at'=>$offer->created_at->format('Y-m-d') ,
            ]);
        }

        $data=[];
        array_push($data , ['offers'=> $all , 'count'=> $count]);
        return ApiController::respondWithSuccess($data);
    }
    public function rate_driver_user($id,Request $request)
    {

        $rules = [
            'rate'=> 'required|in:1,2,3,4,5',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $order= App\User::where('id',$id)->where('type',1)->first();
        if ($order == null){
            $errors = ['key'=>'message',
                'value'=> trans('messages.not_found')
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
        $user= User::find($request->user()->id);

        $orders=App\Rate::updateOrCreate(
            ['from_user_id' => $request->user()->id, 'to_user_id' => $order->id],
            [ 'rate' => $request->rate]
        );
//        $devicesTokens = App\UserDevice::where('user_id', $order->professional_user_id)
//            ->get()
//            ->pluck('device_token')
//            ->toArray();
//
//        if ($devicesTokens) {
//            sendMultiNotification($order->title, trans('messages.The_customer') . " : ".$user->name." ".trans('messages.evaluated_you'). " ". $request->rate." ".trans('messages.on_your_service').$order->title ,$devicesTokens);
//        }
//        saveNotification($order->professional_user_id, $order->title , '1', trans('messages.The_customer') . " : ".$user->name." ".trans('messages.evaluated_you'). " ". $request->rate." ".trans('messages.on_your_service').$order->title);

        return $orders
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();

    }
    public function report_sawaq(Request $request , $id)
    {
        $rules = [
            'report'=> 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

        $created = App\ReportSawa::create([
            'report'=>$request->report,
            'sawaq_id'=>$id,
            'user_id'=>$request->user()->id,
        ]);

        $data=[
            'id'=>intval($created->id),
            'user_id'=>intval($request->user()->id),
            'sawaq_id'=>intval($created->sawaq_id),
            'report' => $created->report,
            'created_at'=>$created->created_at->format('Y-m-d'),

        ];
        return $created
            ? ApiController::respondWithSuccess(array($data))
            : ApiController::respondWithServerErrorArray();

    }
}
