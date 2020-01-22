<?php

namespace App\Http\Controllers\AdminController;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('id' , 'desc')->paginate(8);
        return view('admin.news.index' , compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'title' => 'required',
            'content' => 'required',
            'news_photo' => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ]);
        News::create([
            'user_name' => $request->user_name,
            'user_photo'  => $request->file('user_photo') == null ? null : UploadImage($request->file('user_photo'), 'image', '/uploads/users'),
            'title' =>$request->title,
            'content' =>$request->input('content'),
            'news_photo'  => $request->file('news_photo') == null ? null : UploadImage($request->file('news_photo'), 'image', '/uploads/news_photos'),
        ]);
        return redirect()->route('News')->with('information' , 'تم أنشاء الخبر بنجاح');
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
    public function edit($id)
    {
        $news = News::findOrFail($id);
         return view('admin.news.edit' , compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $this->validate($request , [
            'title' => 'required',
            'content' => 'required',
            'news_photo' => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
        ]);
        $news->update([
            'user_name' => $request->user_name == null ? $news->user_name: $request->user_name,
            'user_photo'  => $request->file('user_photo') == null ? $news->user_photo : UploadImage($request->file('user_photo'), 'image', '/uploads/users'),
            'title' =>$request->title == null ? $news->title : $request->title,
            'content' =>$request->input('content') == null ? $news->content : $request->input('content'),
            'news_photo'  => $request->file('news_photo') == null ? $news->news_photo : UploadImage($request->file('news_photo'), 'image', '/uploads/news_photos'),
        ]);
        return redirect()->route('News')->with('information' , 'تم تعديل الخبر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('News')->with('information' , 'تم حذف الخبر بنجاح');
    }
}
