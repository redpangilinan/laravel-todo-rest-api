<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $completed = $request->input('completed');
        $bool = filter_var($completed, FILTER_VALIDATE_BOOLEAN);
        $todos = ($completed !== null) ? Todo::where('completed', $bool)->get() : Todo::all();
        return $todos;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        return Todo::create($request->only(['title', 'description']));
    }

    public function show($id)
    {
        return Todo::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update($request->only(['title', 'description']));
        return response()->json(['message' => 'Todo updated successfully', 'data' => $todo]);
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json(null, 204);
    }

    public function toggleCompleted($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->completed = !$todo->completed;
        $todo->save();

        return response()->json(['message' => 'Todo status toggled', 'data' => $todo]);
    }
}
