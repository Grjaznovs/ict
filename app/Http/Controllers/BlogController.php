<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogCategoryRelation;
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
        $blog = Blog::query()->with('user')->get();

        return view('blog/index', [
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
            $data['user_id'] = Auth::user()->id;
            $blog = Blog::create($data);
            foreach ($data['categoriesId'] as $id) {
                BlogCategoryRelation::create([
                    'blog_id' => $blog->id,
                    'category_id' => $id
                ]);
            }
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
            return Redirect::back()->withErrors(['msg' => '500']);
        }

        dump($blog);
        return view('blog/edit', [
            'blog' => $blog,
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
            $blog = Blog::findOrFail($id);
            $blog->fill($data);
            $blog->save();
        } catch (\Exception $e) {
            Log::error("BlogController refusalUpdate", ['error' => "{$e}"]);
            Session::flash('message_error', 'check sql function refusalUpdate');
        }

        return redirect('blog');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
