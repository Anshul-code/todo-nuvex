<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
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
                            <select class="form-control" name="status'.$row->id.'" id="status'.$row->id.'">
                                <option value="0" '.($row->status ? '' : 'selected').'>Not Completed</option>
                                <option value="1" '.($row->status ? 'selected' : '').'>Completed</option>
                            </select>
                            ';
                        })
                        ->addColumn('action', function($row) {
                            return '
                                <a
                                    class="btn btn-success"
                                    href="'.route('todos.edit', ['todo' => $row->id]).'"
                                    class="btn-sm"
                                    role="button"
                                >
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                    Edit
                                </a>
                            ';
                        })
                        ->editColumn('title', function($row) {
                            return "<b>{$row->title}</b> &nbsp;&nbsp; <span class='badge badge-warning'>".$row->created_at->diffForHumans()."</span>";
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
        Todo::create($request->validated());

        return redirect()->route('home')->with('success', 'Todo stored.');
    }


}
