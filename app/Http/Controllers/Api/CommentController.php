<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Comment;
class CommentController extends Controller
{
    //
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$comments = Comment::all();
		$data = $comments->toArray();
		if($data == []){
			$response = [
				'message' => 'No Comments Available'
			];
			return response()->json($response, 404);
		}else {
		
			$response = [
				'message' => 'Comments',
				'data' => $data
			];
			return response()->json($response, 200);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

		$comment = Comment::create([
			'content'=>$request->content,
			'user_id'=>$request->user()->id
		]);

		
		

		$data = $comment->toArray();
		$response = [
			'message' => 'New Comment added',
			'data' => $data
		];
		return response()->json($response, 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Find the comment ID
		$comment = Comment::find($id);
		
		//comment not exist
		if(is_null($comment)){
			$response = [
				'data' => 'Empty',
				'message' => 'Comment not exist'
			];
			return response()->json($response, 404);
		}
		//comment exist
		$data = $comment->toArray();
		$response = [
			'data' => $data,
			'message' => 'Comment exist' 
		];
		return response()->json($response, 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, Comment $comment, $id)
	{	$input = $request->all();
		$comment = Comment::find($id);
		$validator = Validator::make($input, [
            'content' => 'required',
            
        ]);

		if ($validator->fails()) {
            $response = [
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

		$comment->content = $input['content'];
		$comment->user_id = Auth::user()->id;
		$comment->save();
		$data = $comment->toArray();

		$response = [
            'success' => true,
            'data' => $data,
            'message' => 'comment updated successfully.'
        ];
  
        return response()->json($response, 200);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$comment = Comment::destroy($id);

		$response = [
			'message' => 'Comment deleted succesfully',
			'data' => $comment
		];
		return response()->json($response, 200);
	}
}
