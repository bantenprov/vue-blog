<?php

namespace Bantenprov\VueBlog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Bantenprov\VueBlog\Models\Blog;
use Bantenprov\VueBlog\Requests\StoreBlogPost;
use Bantenprov\VueBlog\Requests\UpdateBlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Blog::with('user')->latest('updated_at')->whereNull('deleted_at')->get();
        $current_user = Auth::user();
        return view('view::index', compact('articles', 'current_user'));
    }

    public function create()
    {
        $tags = NULL;
        // return response()->json([
        //     'tags' => $tags
        // ]);
        return view('view::create', compact('tags'));
    }

    public function store(StoreBlogPost $request)
    {
        $request['slug'] = str_slug($request->title, '-');
        $post = new Blog();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt;
        $post->slug = str_slug($request->title, '-');
        $user = Auth::user();
        $user->posts()->save($post);

        // return response()->json([
        //     'title' => 'Success',
        //     'type'  => 'success',
        //     'message' => 'Your article has been created.'
        // ]);
        \Session::flash('flash_message', 'Your article has been created');
        return response()->json($user);
        //return redirect()->route('blog.index');
    }

    public function show(Blog $blog)
    {
        $article = $blog;
        $current_user = Auth::user();
        $id_blog  = $article->id;
        // return response()->json([
        //     'articles' => $article,
        //     'current_user' => $current_user
        // ]);
        return view('view::show', compact('article', 'current_user', 'id_blog'));
    }

    public function edit($id)
    {
        $tags = NULL;
        $article = Blog::findOrFail($id);
        $id_blog  = $id;
        // return response()->json([
        //     'articles' => $article,
        //     'tags' => $tags
        // ]);
        return view('view::edit', compact('article', 'tags', 'id_blog'));
    }

    public function update(UpdateBlogPost $request, $id)
    {
        $article = Blog::findOrFail($id);
        $article->update($request->all());
        $this->syncTags($article, $request->input('tag_list'));
        $article->save();

        // return response()->json([
        //     'title' => 'Success',
        //     'type'  => 'success',
        //     'message' => 'Your article has been updated.',
        //     'id'  => $id
        // ]);
        return response()->json($article);
        //return redirect()->route('blog.show', $id);
    }

    public function destroy($id)
    {
        // Blog::find($id)->delete();
        // return response()->json([
        //     'title' => 'Error',
        //     'type'  => 'error',
        //     'message' => 'Data deleted successfully'
        // ]);
        $hapus = Blog::destroy($id);
        // return redirect()->route('blog.index');
        return response()->json($hapus);
    }

    private function syncTags(Blog $article, $tags = [])
    {
        if (empty($tags)) {
            return;
        }

        $article->tags()->sync($tags);
    }

    private function createPost(StoreBlogPost $request)
    {
        $request['slug'] = str_slug($request->title, '-');
        $article = Auth::user()
        ->posts()
        ->save(new Blog($request->all()));
        //return response()->json($article);
        return $article;
    }

    public function getData(Request $request)
    {
        $cari = $request->get('cari');
        $id = $request->get('id');
        $current_user = Auth::user();
        if($cari){
          if($id){
            $articles = Blog::with('user')
                            ->latest('updated_at')
                            ->where('id', $id)
                            ->where('title', 'LIKE','%'.$cari.'%')
                            ->whereNull('deleted_at')
                            ->paginate(5)
                            ->appends($request->only('cari'));
          }else {
            $articles = Blog::with('user')
                            ->latest('updated_at')
                            ->where('title', 'LIKE','%'.$cari.'%')
                            ->whereNull('deleted_at')
                            ->paginate(5)
                            ->appends($request->only('cari'));
          }
        } else {
          if($id){
            $articles = Blog::with('user')
                            ->latest('updated_at')
                            ->where('id', $id)
                            ->whereNull('deleted_at')
                            ->paginate(5);
          }else {
            $articles = Blog::with('user')
                            ->latest('updated_at')
                            ->whereNull('deleted_at')
                            ->paginate(5);
          }
        }
        return response()->json([
            'articles' => $articles,
            'current_user' => $current_user
        ]);
    }
}
