<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use Purifier;

use App\Post;
use App\Category;
use App\Location;
use App\PostImage;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show', 'search']);
        $this->middleware('admin')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all()->pluck('city', 'id');
        $categories = Category::all()->pluck('name', 'id');

        return view( 'post.create', compact('locations', 'categories') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'images.*'    => 'image|max:3000',
        ]);

        $post = new Post();

        $post->title       = strip_tags($request->title);
        $post->description = Purifier::clean($request->description);
        $post->category_id = $request->category_id;
        $post->location_id = $request->location_id;
        $post->save();

        if ($request->hasFile('images')){

            $location     = "images/posts/$post->id";
            $disk         = 'public';
            $index        = 0;
            $postImages   = collect();
            foreach ($request->file('images') as $image){
                $fileName = $index . '.' . $image->getClientOriginalExtension();
                $image->storeAs($location, $fileName, $disk);
                $postImages->push(new PostImage(['path' => "$location/$fileName"]));
                $index++;
            }

            $post->images()->saveMany($postImages);
        }        

        return back()->with('posted', 'New post created successfully.');
    }

    private function storeImage($images, $post){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('post.edit', compact('post'));
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
        //
    }

    /**
     * Search for posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword  = $request->keyword;
        $locationId = $request->locationId;
        $categoryId = $request->categoryId;

        $dynamicFilters = collect([['title', 'like', '%' . $keyword . '%']]);

        $posts = collect();

        // if locationId exist than add accordingly
        if ($request->has('locationId')) {
            if (!is_numeric($locationId)) {
                return view('post.index', compact('posts'));
            }
            $dynamicFilters->push(['location_id', '=', $locationId]);
        }

        // if categoryId exist than add accordingly
        if ($request->has('categoryId')) {
            if (!is_numeric($categoryId)) {
                return view('post.index', compact('posts'));
            }
            $dynamicFilters->push(['category_id', '=', $categoryId]);
        }

        $posts = Post::where($dynamicFilters->toArray())->get();

        return view('post.index', compact('posts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return back();
    }
}
