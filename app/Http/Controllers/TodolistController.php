<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todolist(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view('todolist.todolist', [
            'title' => 'todolist',
            'todolist' => $todolist,
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todolist = $this->todolistService->getTodolist();
            return response()->view('todolist.todolist', [
                'title' => 'todolist',
                'todolist' => $todolist,
                'error' => 'todo can not blank'
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todolist']);
        //cttn: mana yang lebih dipilih?
        // $todolist = $this->todolistService->getTodolist();
        // return response()->view('todolist.todolist', [
        //     'title' => 'todolist',
        //     'todolist' => $todolist,
        // ]);
    }

    public function removeTodo(Request $request, string $todoId)
    {
        // diambil dari mana todoid? dari parameter di route pada {id}. saat action menembak dan mengambi
        // id dari todoId yang di iterasi di tampilan
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
