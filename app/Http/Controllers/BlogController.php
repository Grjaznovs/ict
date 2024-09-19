<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogDestroyRequest;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogEditResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogShowResource;
use App\Models\Blog;
use App\Models\Category;
use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = Blog::query()
            ->with('user')
            ->filter(request(['search']))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('blog/index', [
            'search' => request('search'),
            'blog' => BlogResource::collection($blog)->toJson()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog/create', [
            'categories' => Category::query()->select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $blog = Auth::user()->blog()->save(new Blog($data));
            $blog->blogCategoryRelationSync()->sync($data['categoriesId']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("BlogController refusalStore", ['error' => "{$e}"]);
            Session::flash('message_error', 'check sql function refusalStore');
        }

        return redirect('blog');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::query()->with('blogCategoryRelation')->find($id);
        if ($blog->user_id !== Auth::user()->id) {
            return Redirect::back()->withErrors(['msg' => '403']);
        }

        return view('blog/edit', [
            'blog' => json_decode((new BlogEditResource($blog))->toJson(), true),
            'categories' => Category::query()->select('id', 'name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $blog = Blog::findOrFail($id);
            $blog->fill($data);
            $blog->save();
            $blog->blogCategoryRelationSync()->sync($data['categoriesId']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("BlogController refusalUpdate", ['error' => "{$e}"]);
            Session::flash('message_error', 'check sql function refusalUpdate');
        }

        return redirect('blog');
    }

    /**
     * Show the form for show a new resource.
     */
    public function show(string $id)
    {
        $blog = Blog::query()->with(['user', 'comment', 'comment.user'])->find($id);

        return view('blog/show', [
            'data' => json_decode((new BlogShowResource($blog))->toJson(), true),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogDestroyRequest $request)
    {
        $data = $request->validated();
        $blog = Blog::findOrFail($data['id']);
        try {
            if (Auth::user()->id === $blog->user_id) {
                DB::beginTransaction();
                $blog->comment()->delete();
                $blog->blogCategoryRelation()->delete();
                $blog->delete();
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("BlogController refusalDestroy", ['error' => "{$e}"]);
            Session::flash('message_error', 'check sql function refusalDestroy');
        }

        return Redirect::back();
    }
}
