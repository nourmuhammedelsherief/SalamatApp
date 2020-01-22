<?php

namespace App\Http\Controllers\AdminController;


use App\Nationality;
use App\Order;
use App\SawaqOfferPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Auth;


class OrderController extends Controller
{
    //
    public function student()
    {
        $places = Order::orderBy('id','desc')->where('order_type',1)->paginate(10);
        return view('admin.orders.student',compact('places'));

    }
    public function employee()
    {
        $places = Order::orderBy('id','desc')->where('order_type',2)->paginate(10);
        return view('admin.orders.employee',compact('places'));

    }
    public function rent()
    {
        $places = Order::orderBy('id','desc')->where('order_type',3)->paginate(10);
        return view('admin.orders.rent',compact('places'));

    }
    public function offer($id)
    {
        $offer = Order::find($id);

            return view('admin.orders.offer',compact('offer'));


    }

    public function commission()
    {
       $offers=  SawaqOfferPrice::where('end_date','!=',null)->get();

            return view('admin.orders.commission',compact('offers'));


    }
    public function edit_commission($id)
    {
       $offers=  SawaqOfferPrice::find($id);

            return view('admin.orders.edit_commission',compact('offers'));


    }
    public function update_commission($id,Request $request)
    {
        $this->validate($request, [
            "status"  => "required",


        ]);
       $offers=  SawaqOfferPrice::find($id)->update(['commission_status'=>$request->status]);

        return redirect('admin/commission');



    }






}
