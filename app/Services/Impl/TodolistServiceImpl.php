<?php

namespace App\Services\Impl;

use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{
    public function saveTodo(string $id, string $todo): void
    {
        // Saving to session
        if (!Session::exists('todolist')) {
            Session::put('todolist', []);
        }

        Session::push('todolist', [
            "id" => $id,
            "todo" => $todo
        ]);
    }

    public function getTodoList(): array
    {
        return Session::get("todolist", []);
    }

    public function deleteTodo(string $id): void
    {
        $todolist = Session::get("todolist");

        foreach ($todolist as $index => $value) {
            if ($value['id'] == $id) {
                unset($todolist[$index]);
                break;
            }
        };

        Session::put('todolist', $todolist);
    }
}
