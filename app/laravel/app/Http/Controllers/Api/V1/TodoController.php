<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Todo;
use Validator;

class TodoController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'limit'          => 'nullable|numeric|min:1',
      'page'           => 'nullable|numeric|min:1',
      'orderByField'   => 'nullable|alpha',
      'orderByType'    => 'nullable|alpha',
      'conditionField' => 'nullable|alpha'
    ]);

    if($validator->fails())
      return $this->validateFail($validator);

    $limit    = (int)e($request->get('limit') ?? 10);
    $page     = (int)e($request->get('page') ?? 1);
    $field    = (string)e($request->get('orderByField') ?? 'id');
    $sortType = (string)e($request->get('orderByType') ?? 'desc');

    $todoData = Todo::select('id', 'subject', 'detail', 'status')
                ->orderBy($field, $sortType)
                ->take($limit)
                ->skip(($page - 1) * $limit);

    if($request->has('conditionField') && $request->has('conditionValue'))
      $todoData->where(e($request->get('conditionField')), e($request->get('conditionValue')));

    $result = $todoData->get();

    if($result->isEmpty())
    {
      return response()->json([
        'code'    => '01',
        'message' => 'No data in system.'
      ], 404);
    }
    else
    {
      return response()->json([
        'code'  => '00',
        'count' => $todoData->count(),
        'data'  => $result
      ]);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'subject' => 'required',
      'detail'  => 'required'
    ]);

    if($validator->fails())
      return $this->validateFail($validator);

    $task = Todo::create([
      'subject' => e($request->get('subject')),
      'detail'  => e($request->get('detail')),
      'status'  => 'pending'
    ]);

    if(!empty($task->id))
      return response()->json([
        'code'    => '00',
        'id'      => $task->id,
        'message' => 'create task success.'
      ]);

    return response()->json([
      'code'    => '01',
      'message' => 'can\'t create task.'
    ], 404);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(int $id)
  {
    $result = Todo::select('id', 'subject', 'detail', 'status')
                ->find(e($id));

    if($result)
      return response()->json(array_merge(['code' => '00'], $result->toArray()));

    return response()->json([
      'code'    => '01',
      'message' => 'No data in system.'
    ], 404);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, int $id)
  {
    if(($request->method() == 'PUT'))
      return $this->putUpdate($request, $id);

    return $this->patchUpdate($request, $id);
  }

  private function putUpdate(Request $request, int $id)
  {
    $result = Todo::find($id)->update([
      'subject' => e($request->get('subject')),
      'detail'  => e($request->get('detail'))
    ]);

    if($result)
      return response()->json([
        'code'    => '00',
        'message' => 'update task success.'
      ]);

    return response()->json([
      'code'    => '01',
      'message' => 'can\'t update task.'
    ], 404);
  }

  private function patchUpdate(Request $request, int $id)
  {
    $validator = Validator::make($request->all(), [
      'status' => 'required|alpha',
    ]);

    if($validator->fails())
      return $this->validateFail($validator);

    $result = Todo::find($id)->update([
      'status' => e($request->get('status'))
    ]);

    if($result)
      return response()->json([
        'code'    => '00',
        'message' => 'change status task success.'
      ]);

    return response()->json([
      'code'    => '01',
      'message' => 'can\'t change status task.'
    ], 404);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(int $id)
  {
    $result = Todo::find($id);

    if($result)
    {
      $result->delete();

      return response()->json([
        'code'    => '00',
        'message' => 'delete task success.'
      ]);
    }

    return response()->json([
      'code'    => '01',
      'message' => 'can\'t delete task.'
    ], 404);
  }

  private function validateFail($validator)
  {
    $message = '';

    foreach($validator->messages()->all() as $word)
      $message = ($message ? $message . ' ' : '') . $word;

    return response()->json([
      'code'    => '01',
      'message' => $message
    ], 404);
  }
}
