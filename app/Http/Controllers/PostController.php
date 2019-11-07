<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Category;
use Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function getCategories(){
        $cats=Category::get();
        return view('posts.categories')->with(['cats'=>$cats]);
    }

    public function postNewCategories(Request $request){
        $this->validate($request,[
            'cat_name'=>"required|unique:categories"
        ]);
        $c=new Category();
        $c->cat_name=$request['cat_name'];
        $c->save();
        return redirect()->back()->with('info','The new category have been saved.');
    }
    public function getDeleteCategory($id){
        //$c=Category::where('id',$id)->firstOrFail();//first();
        $c=Category::whereId($id)->firstOrFail();//first();
        $c->delete();
        return redirect()->back()->with('info','The selected category have been deleted.');
    }
    public  function postUpdateCategory(Request $request){
        $cat_id=$request['cat_id'];
        $cat=Category::whereId($cat_id)->firstOrFail();
        $cat->cat_name=$request['cat_name'];
        $cat->update();
        return redirect()->back()->with('info','The selected category have been updated.');

    }
    public function getSearchPost(Request $request){
        $q=$request['q'];
        $posts=Post::where("item_name","LIKE","%$q%")
        ->orWhere("price","LIKE","%$q%")
        ->paginate();
        return view('posts/posts')->with(['posts'=>$posts]);
    }
    public  function getPosts(){
        $posts=Post::OrderBy('id','desc')->paginate("4");
        return view('posts/posts')->with(['posts'=>$posts]);
    }
    public function getNewPost(){
        $cats=Category::get();
        return view('posts.new-posts')->with(['cats'=>$cats]);
    }
    public function postNewPost(Request $request){
        $this->validate($request,[
            'item_name'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,gif',
            'price'=>'required|numeric',
            'category'=>'required',
            'description'=>'required'
        ]);
        $img_name=$request['item_name']."-".date("dmyhis").".".$request->file('image')->getClientOriginalExtension();//getClientOriginalName();
        $img_file=$request->file('image');

        $p=new Post();
        $p->item_name=$request['item_name'];
        $p->price=$request['price'];
        $p->image=$img_name;
        $p->category_id=$request['category'];
        $p->description=$request['description'];
        $p->user_id=Auth::id();//Auth::User()->id;
        $p->save();
        //uploading file
        Storage::disk('posts')->put($img_name,File::get($img_file));

        return redirect()->back()->with('info','The new post have been created.');
    }
    public function getImage($file_name){
        $file=Storage::disk('posts')->get($file_name);
        return response($file)->header("Content-type","*.*");
    }
    public function getDropPost($id){
        $post=Post::whereId($id)->firstOrFail();
        Storage::disk('posts')->delete($post->image);
        $post->delete();
        return redirect()->back()->with('info','The selected post have been deleted.');

    }
    public function getEditPost($id){
        $cats=Category::get();
        $post=Post::whereId($id)->firstOrFail();
        return view('posts.edit-post')->with(['post'=>$post,'cats'=>$cats]);
    }
    public function postUpdatePost(Request $request){
        $id=$request['id'];
        $post=Post::where('id',$id)->firstOrFail();
        $image=$request->file('image');
        if($image){
            //delete from storage
            Storage::disk('posts')->delete($post->image);

            //insert to storage
            $img_name=$request['item_name']."-".date('dmyhis').".".$request->file('image')->getClientOriginalName();
            $img=$request->file('image');
            Storage::disk('posts')->put($img_name,File::get($img));

            //insert to database
            $post->image=$img_name;
        }
        $post->item_name=$request['item_name'];
        $post->price=$request['price'];
        $post->description=$request['description'];
        $post->category_id=$request['category'];
        $post->update();
        return redirect()->route('posts')->with('info','The selected post have been updated');
    }
}
