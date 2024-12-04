<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            //キーワードを入力して、タイトルの曖昧検索
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            //キーワードを入力して、投稿内容の曖昧検索
            ->orWhere('post', 'like', '%'.$request->keyword.'%')
            //キーワードを入力して、完全一致だったらサブカテゴリー検索
            ->orWhereHas('subCategories', function ($query) use ($request) {
                $query->where('sub_category', '=', $request->keyword);
                })->get();
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')
            //キーワードを入力して、サブカテゴリーが完全に一致していたら
            ->whereHas('subCategories', function ($query) use ($sub_category) {
            $query->where('sub_category', '=', $sub_category);
            })->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        // dd($request);
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $post->subCategories()->attach($request->post_category_id);
        // 上記の subCategories() はPost モデルで定義されたリレーションメソッド
        // 上記の attach() メゾットは多対多のリレーションの時に、中間テーブルのレコードを新規作成するためのもの
        //                ()の中にある $request->post_category_id は送る値を記述する

        return redirect()->route('post.show');
    }

    public function postEdit(Request $request){
        $request->validate([
            'post_body' => ['required', 'string' , 'max:5000'],
            'post_title' => ['required', 'string' , 'max:100'],
        ],[
            'post_body.required' => '※投稿内容は必須です',
            'post_body.string' => '※投稿は文字列で入力してください',
            'post_body.max' => '※投稿は5000文字以内で入力してください',
            'post_title.required' => '※タイトルは必須です',
            'post_title.string' => '※タイトルは文字列で入力してください',
            'post_title.max' => '※タイトルは100文字以内で入力してください',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    public function mainCategoryCreate(Request $request){
        $request->validate([
            'main_category_name' => ['required', 'max:100', 'string', 'unique:main_categories,main_category'],
        ],[
            'main_category_name.required' => '※メインカテゴリーは必須です',
            'main_category_name.max' => '※メインカテゴリーは100文字以内で入力してください',
            'main_category_name.string' => '※メインカテゴリーは文字列で入力してください',
            'main_category_name.unique' => '※このメインカテゴリーはすでに登録されています',
        ]);
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(Request $request){
        $request->validate([
            'main_category_id' => ['required', 'exists:main_categories,id'],
            'sub_category_name' => ['required', 'max:100', 'string', 'unique:sub_categories,sub_category'],
        ],[
            'main_category_id.required' => '※メインカテゴリーは必須です',
            'main_category_id.exists' => '※このメインカテゴリーは登録されていません',
            'sub_category_name.required' => '※サブカテゴリーは必須です',
            'sub_category_name.max' => '※サブカテゴリーは100文字以内で入力してください',
            'sub_category_name.string' => '※サブカテゴリーは文字列で入力してください',
            'sub_category_name.unique' => '※このサブカテゴリーはすでに登録されています',
        ]);
        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name
        ]);
        //dd($sub_category_nam);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        $request->validate([
            'comment' => ['required', 'string' , 'max:250'],
        ],[
            'comment.required' => '※内容は必須です',
            'comment.string' => '※文字列で入力してください',
            'comment.max' => '※250文字以内で入力してください',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //いいねする機能
    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    //いいねを消す機能
    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
