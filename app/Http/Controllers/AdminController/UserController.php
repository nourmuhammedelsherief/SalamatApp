<?php

namespace App\Http\Controllers\AdminController;

use App\City;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

use Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // // 1 for user 2 for single 3 for company


            if ($id == 1){
                // 1 for user 2 for single 3 for company
                $users =User::orderBy('id','desc')->where('type',1)->get();
                return view('admin.users.index_user',compact('users'));
            }elseif ($id == 2){
                $users =User::orderBy('id','desc')->where('type',2)->get();
                return view('admin.users.index_single',compact('users'));
            }


//


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //

            $countries = City::all();
            if ($id == 1){
                //1 for diploma
                return view('admin.users.create_user' ,compact('countries'));
            }elseif ($id == 2){

                return view('admin.users.create_single');
            }



//

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$type)
    {
        //

        if($type == 1){

            $this->validate($request, [
                'phone_number'          => 'required|unique:users',
                'name'                  => 'required|max:255',
                'password'              => 'required|string|min:6',
                'password_confirmation' => 'required|same:password',
                'national_id'           => 'required',
                'car_number'            => 'required',
                'nationality_id'        => 'required',
                'service_type'          => 'nullable',
                'other'                 => 'nullable',
                'car_type'              => 'required',
                'national_image'        => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
                'car_image'             => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
                'licence_image'         => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
                'id_image'              => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
                'paper_image'           => 'required|mimes:jpeg,bmp,png,jpg|max:5000',

            ]);

             // end certificate_image
            $user = User::create([
                'phone_number'   => $request->phone_number,
                'name'           => $request->name,
                'active'         => $request->active,
                'national_id'    =>$request->national_id,
                'password'       => Hash::make($request->password),
                'nationality_id' => $request->nationality_id,
                'car_number'     =>$request->car_number,
                'type'           => 1,
                'car_type'       => $request->car_type,
                'service_type'   => $request->service_type == null ? '0' : $request->service_type,
                'other'          => $request->other == null ? '0' : $request->other,
                'image'          => $request->file('national_image') == null ? null : UploadImage($request->file('national_image'), 'image', '/uploads/national_images'),
                'car_image'      => $request->file('car_image') == null ? null : UploadImage($request->file('car_image'), 'image', '/uploads/car_images'),
                'licence_image'  => $request->file('licence_image') == null ? null : UploadImage($request->file('licence_image'), 'image', '/uploads/licence_images'),
                'id_image'       => $request->file('id_image') == null ? null : UploadImage($request->file('id_image'), 'image', '/uploads/id_images'),
                'paper_image'    => $request->file('paper_image') == null ? null : UploadImage($request->file('paper_image'), 'image', '/uploads/paper_images'),

            ]);
            return redirect('admin/user/1');
        }elseif ($type == 2){
            $this->validate($request, [
                'phone_number'                 => 'required|unique:users',
                'name'                  => 'required|max:255',
                'active'                  => 'required',
                'image'            => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|same:password',

            ]);
            $user= User::create([
                'phone_number'                 => $request->phone_number,
                'name'                  => $request->name,
                'active'            => $request->active,
                'type'            => 2,
                'password' => Hash::make($request->password),
                'image'            => $request->file('image') == null ? null :UploadImage($request->file('image'), 'image', '/uploads/users'),


            ]);

            return redirect('admin/user/2');
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$type)
    {


            $countries = City::all();

            if ($type == 1){
                //1 for diploma
                $user = User::findOrfail($id);
                return view('admin.users.edit_user' ,compact('countries','user'));
            }elseif ($type == 2){
                $user = User::findOrfail($id);
                return view('admin.users.edit_single' ,compact('countries','user'));
            }
//


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id,$type)
    {

        //
        if($type == 1){
             $this->validate($request, [
                'phone_number' => 'required|numeric|unique:users,phone_number,'.$id,
                'name'                  => 'required|max:255',
                'national_id'           => 'required',
                'car_number'            => 'required',
                'nationality_id'        => 'required',
                'service_type'          => 'nullable',
                'other'                 => 'nullable',
                'car_type'              => 'required',
                'national_image'        => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
                'car_image'             => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
                'licence_image'         => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
                'id_image'              => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
                'paper_image'           => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
            ]);
            $users = User::find($id);


             User::where('id',$id)->first()->update([
                'phone_number'   => $request->phone_number,
                'name'           => $request->name,
                'active'         => $request->active,
                'national_id'    =>$request->national_id,
                'nationality_id' => $request->nationality_id,
                'car_number'     =>$request->car_number,
                'type'           => 1,
                'car_type'       => $request->car_type,
                'service_type'   => $request->service_type == null ? '0' : $request->service_type,
                'other'          => $request->other == null ? '0' : $request->other,
                'image'          => $request->file('national_image') == null ? $users->image : UploadImage($request->file('national_image'), 'image', '/uploads/national_images'),
                'car_image'      => $request->file('car_image') == null ? $users->car_image : UploadImage($request->file('car_image'), 'image', '/uploads/car_images'),
                'licence_image'  => $request->file('licence_image') == null ? $users->licence_image : UploadImage($request->file('licence_image'), 'image', '/uploads/licence_images'),
                'id_image'       => $request->file('id_image') == null ? $users->id_image : UploadImage($request->file('id_image'), 'image', '/uploads/id_images'),
                'paper_image'    => $request->file('paper_image') == null ? $users->paper_image : UploadImage($request->file('paper_image'), 'image', '/uploads/paper_images'),
            ]);

            return redirect()->back()->with('information', 'تم تعديل بيانات المستخدم');
        }elseif ($type == 2){
            $this->validate($request, [
                'phone_number'                 => 'required|unique:users,phone_number,'.$id,
                'name'                  => 'required|max:255',
                'active'                  => 'required',
                'image'            => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',


            ]);


            $users= User::find($id);

            User::where('id',$id)->first()->update([
                'phone_number'                 => $request->phone_number,
                'name'                  => $request->name,
                'type'            => 2,
                'password' => Hash::make($request->password),
                'image'            => $request->file('image') == $users->image ? null :UploadImage($request->file('image'), 'image', '/uploads/users'),

            ]);

            return redirect()->back()->with('information', 'تم تعديل بيانات المستخدم');
        }

    }
    public function update_pass(Request $request, $id)
    {
        //
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',

        ]);
        $users = User::findOrfail($id);
        $users->password = Hash::make($request->password);

        $users->save();

        return redirect()->back()->with('information', 'تم تعديل كلمة المرور المستخدم');
    }
    public function update_privacy(Request $request, $id)
    {
        //
        $this->validate($request, [
            'active' => 'required',

        ]);
        $users = User::findOrfail($id);
        $users->active =$request->active;

        $users->save();

        return redirect()->back()->with('information', 'تم تعديل اعدادات المستخدم');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            $users = User::find($id);
            $orders = Order::whereUser_id($id)->get();
            foreach ($orders as $order)
            {
                $order->delete();
            }
            $users->delete();
            return back();
    }
}
