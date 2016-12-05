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
    const POST_IMAGE_MAX = 10;

    const SORTS_VIEW = [
        1 => 'Newest First',
        2 => 'Oldest First',
    ];

    const SORTS_BY = [
        1 => ['field' => 'created_at', 'order' => 'desc'],
        2 => ['field' => 'created_at', 'order' => 'asc']
    ];

    
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show', 'search']);
        $this->middleware('can:create,App\Post')->except(['index', 'show', 'search']);
    }

    private function storeImage($images, $post){
        $location     = "images/posts/$post->id";
        $disk         = 'public';
        $countImage   = $post->images()->withTrashed()->count();
        $index        = $countImage ? $countImage : 0;
        $postImages   = collect();
        foreach ($images as $image){
            $fileName = $index . '.' . $image->getClientOriginalExtension();
            $image->storeAs($location, $fileName, $disk);
            $postImages->push(new PostImage(['path' => "$location/$fileName"]));
            $index++;
        }

        return $post->images()->saveMany($postImages);
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
        return view( 'post.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $erroMessages = [
            'images.max' => 'The total :attribute may not be greater than :max'
        ];

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'images'      => 'sometimes|max:'.PostController::POST_IMAGE_MAX,
            'images.*'    => 'sometimes|image|max:3000',
        ], $erroMessages);
        
        $post = new Post();

        $post->title       = strip_tags($request->title);
        $post->description = Purifier::clean($request->description);
        $post->category_id = $request->category_id;
        $post->location_id = $request->location_id;
        $post->save();

        if ($request->hasFile('images')){
            $this->storeImage($request->file('images'), $post);
        }        

        return redirect()->route('posts.show', $post->id);
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
        $post       = Post::findOrFail($id);

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
        $post = Post::findOrFail($id);
        $images = $post->images();

        $totalLeftImage = PostController::POST_IMAGE_MAX - $images->count();

        $erroMessages = [
            'images.max' => 'The total :attribute may not be greater than ' . PostController::POST_IMAGE_MAX
        ];

        $validate = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'images'      => 'sometimes|max:'.$totalLeftImage,
            'images.*'    => 'sometimes|image|max:3000',
        ];

        $this->validate($request, $validate, $erroMessages);

        $post->title       = strip_tags($request->title);
        $post->description = Purifier::clean($request->description);
        $post->category_id = $request->category_id;
        $post->location_id = $request->location_id;
        $post->save();

        if ($request->hasFile('images')){
            $this->storeImage($request->file('images'), $post);
        }
        
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Search for posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword     = $request->keyword;
        $location_id = $request->location_id;
        $category_id = $request->category_id;

        $titleFilter = collect([['title', 'like', '%' . $keyword . '%']]);
        $descriptionFilter = collect([['description', 'like', '%' . $keyword . '%']]);
        // $posts = Post::where('title', 'like', "%$keyword%");
                    // ->orWhere('description', 'like', "%$keyword%");

        // if location_id exist than add accordingly
        if ($request->has('location_id')) {
            $titleFilter->push(['location_id', '=', $location_id]);
            $descriptionFilter->push(['location_id', '=', $location_id]);
            // $posts = $posts->where('location_id', $location_id);
        }

        // if category_id exist than add accordingly
        if ($request->has('category_id')) {
            $titleFilter->push(['category_id', '=', $category_id]);
            $descriptionFilter->push(['category_id', '=', $category_id]);
            // $posts = $posts->where('category_id', $category_id);
        }

        $posts = Post::Where($titleFilter->toArray())
                        ->orWhere($descriptionFilter->toArray());

        // if sort exist
        if ($request->has('sort') && array_key_exists($request->sort, PostController::SORTS_BY)){
            $sortBy = PostController::SORTS_BY[$request->sort];
            $posts = $posts->orderBy($sortBy['field'], $sortBy['order']);
        } else {
            $posts = $posts->orderBy('title', 'asc')->orderBy('description', 'asc');
        }

        // query to database to get posts
        $posts = $posts->get();

        // sorts list for view to display
        $sorts = PostController::SORTS_VIEW;

        return view('post.search', compact('posts', 'sorts'));
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
        // return redirect()->route('posts.index');
    }
}
