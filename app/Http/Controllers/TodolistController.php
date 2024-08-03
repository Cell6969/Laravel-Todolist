<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function todoList(Request $request)
    {
        $todolist = $this->todoListService->getTodoList();
        return response()->view('todolist.todolist', [
            'title' => 'Todo List',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todolist = $this->todoListService->getTodoList();

        $todo = $request->input("todo");
        if(empty($todo)){
            return response()->view("todolist.todolist", [
                "error" => "Todo is required",
                "title" => "Todo List",
                "todolist" => $todolist
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $todoId)
    {
        $this->todoListService->deleteTodo($todoId);
        return redirect()->action([TodolistController::class,'todoList']);

    }
}
