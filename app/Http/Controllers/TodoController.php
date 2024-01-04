<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\UpdateTodoStatusRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TodoController extends Controller
{
    /**
     * Get list of todos
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $query = Todo::query();

        return DataTables::of($query)
                        ->editColumn('status', function($row){
                            return '
                            <div class="icheck-primary d-inline">
                                <input
                                    type="checkbox"
                                    class="custom-todo-check"
                                    value="1"
                                    data-id="'.$row->id.'"
                                    name="status'.$row->id.'"
                                    id="status'.$row->id.'"
                                    '.($row->status
                                    ?
                                    'checked'
                                    :
                                    '').'
                                >
                                <label for="status'.$row->id.'"></label>
                            </div>
                            ';
                        })
                        ->addColumn('action', function($row) {
                            return '
                                <a
                                    class="btn btn-success btn-sm"
                                    href="'.route('todos.edit', ['todo' => $row->id]).'"
                                    role="button"
                                >
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                    Edit
                                </a>
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm delete-todo"
                                    data-id="'.$row->id.'"
                                ><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                            ';
                        })
                        ->editColumn('title', function($row) {
                            return "<b>{$row->title}</b> &nbsp;&nbsp; <span class='badge badge-warning'>".$row->created_at->diffForHumans()."</span> &nbsp;&nbsp;" 
                                    .($row->status ? '<span class="badge badge-success">Completed</span>' 
                                                    : '<span class="badge badge-danger">Not Completed</span>');
                        })
                        ->rawColumns(['status','title','action'])
                        ->make(true);
    }

    /**
     * Create todo page
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('pages.todos.create');
    }

    /**
     * Store new Todo
     *
     * @param \App\Http\Requests\StoreTodoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        Todo::create($request->validated() + [
            'status' => $request->exists('status')
        ]);

        return redirect()->route('home')->with('success', 'Todo stored.');
    }

    /**
     * Update status of todo
     *
     * @param \App\Http\Requests\UpdateTodoStatusRequest $request
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(UpdateTodoStatusRequest $request, Todo $todo): JsonResponse
    {
        $todo->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Todo updated.'
        ]);
    }

    /**
     * Edit todo page
     *
     * @return \Illuminate\View\View
     */
    public function edit(Todo $todo): View
    {
        return view('pages.todos.edit', compact('todo'));
    }

    /**
     * Update todo
     *
     * @param \App\Http\Requests\UpdateTodoRequest $request
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        $todo->update($request->validated() + [
            'status' => $request->exists('status')
        ]);

        return redirect()->route('home')->with('success', 'Todo updated.');
    }

    /**
     * Delete Todo
     *
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Todo deleted.'
        ]);
    }

}
