<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::where('user_id','=',Auth::user()->id)->get();
        return view("dashboard",[
            'tasks' => Todo::where('user_id','=',Auth::user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input["user_id"] = Auth::user()->id;
        // $validator = Validator::make($input, [
        //     'task' => 'required|max:255',

        // ]);

        // if($validator->fails()){
        //     // return view("dashboard");
        // }
        $request->validate([
            'task' => 'required|max:255'
        ]);
        Todo::create($input);
        return redirect('dashboard')->with('success', "TODO created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        $todo = Todo::find($todo->id);
        if ($todo->completed){
            $todo->update(['completed' => false]);
            return redirect()->back()->with('success', "TODO marked as incomplete!");
        }else {
            $todo->update(['completed' => true]);
            return redirect()->back()->with('success', "TODO marked as complete!");
        }
    }


    public function edit($id)
    {
        $todo = Todo::find($id);
        return view('edit')->with(['id' => $id, 'task' => $todo]);
    }


    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'task' => 'required|max:255'
        ]);
        $updateTodo = Todo::find($request->id);
        // dd($updateTodo);
        $updateTodo->update(['task' => $request->task]);
        return redirect('dashboard')->with('success', "TODO updated successfully!");
    }


    public function delete($id){
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->back()->with('success', "TODO deleted successfully!");
    }
}
