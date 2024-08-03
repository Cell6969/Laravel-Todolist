<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo("1", "do");

        $todolist = Session::get("todolist");
        foreach ($todolist as $todo) {
            self::assertEquals("1", $todo["id"]);
            self::assertEquals("do", $todo["todo"]);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "do 1"
            ],
            [
                "id"=> "2",
                "todo" => "do 2"
            ]
        ];

        $this->todoListService->saveTodo("1", "do 1");
        $this->todoListService->saveTodo("2", "do 2");

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testDeleteTodo()
    {
        $this->todoListService->saveTodo("1", "do");
        $this->todoListService->saveTodo("2", "dodo");

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->deleteTodo("1");
        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->deleteTodo("2");
        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
