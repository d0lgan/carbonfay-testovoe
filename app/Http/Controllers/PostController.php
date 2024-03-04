<?php
namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = \auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $posts = Post::paginate(15);

        return response()->json([
            'message' => 'All posts',
            'posts' => $posts,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,100|unique:posts',
            'content' => 'required|string|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $post = Post::create(array_merge(
            $validator->validated(),
            ['user_id' => $this->user->id]
        ));

        LogActivity::addToLog($this->user->username . " created post id - " . $post->id);

        return response()->json([
            'message' => 'Post successfully stored',
            'post' => $post,
        ], 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:2,100|unique:posts',
            'content' => 'required|string|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $post = Post::findOrFail($id);
        $post->update(array_merge(
            $validator->validated(),
            ['user_id' => \auth('api')->user()->id]
        ));

        LogActivity::addToLog($this->user->username . " updated post id - " . $post->id);

        return response()->json([
            'message' => 'Post successfully updated',
            'post' => $post,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Post::destroy($id);

        LogActivity::addToLog($this->user->username . " deleted post id - " . $id);

        return response()->json([
            'message' => 'Post successfully deleted',
        ], 201);
    }
}
