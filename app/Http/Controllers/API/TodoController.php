<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Todo;
use App\Http\Resources\Todo as TodoResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class TodoController extends BaseController
{
    public function index()
    {
        // $Todos = Todo::all(); //We need get task of only the user.
        $todos = Todo::where('user_id','=',Auth::user()->id)->get();
        return $this->sendResponse(TodoResource::collection($todos), 'Tasks fetched.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input["user_id"] = Auth::user()->id;
        $validator = FacadesValidator::make($input, [
            'task' => 'required|max:255',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $Todo = Todo::create($input);
        return $this->sendResponse(new TodoResource($Todo), 'Task created.');
    }

    public function show($id)
    {
        $Todo = Todo::find($id);
        if (is_null($Todo)) {
            return $this->sendError('Task does not exist.');
        }
        $status = $Todo->completed;
        if ($status){
            $Todo->completed = false;
        }
        else {
            $Todo->completed = true;
        }
        //Why is ? false:true ; NOt working
        $Todo->save();
        return $this->sendResponse(new TodoResource($Todo), 'Task marked as completed');
    }

    public function update(Request $request, Todo $Todo)
    {
        $input = $request->all();
        $validator = FacadesValidator::make($input, [
            'task' => 'required|max:255',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $Todo->task = $input['task'];

        $Todo->save();

        return $this->sendResponse(new TodoResource($Todo), 'Task updated.');
    }

    public function destroy(Todo $Todo)
    {
        $Todo->delete();
        return $this->sendResponse([], 'Task deleted.');
    }
}
