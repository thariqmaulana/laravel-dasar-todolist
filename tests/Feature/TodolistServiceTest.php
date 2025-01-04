<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistService()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo('1', 'belajar');

        $todolist = Session::get('todolist');

        foreach ($todolist as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('belajar', $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        $todolist = $this->todolistService->getTodolist();

        self::assertEquals([], $todolist);
    }

    public function testGetTodolist()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'AAA'
            ],
            [
                'id' => '2',
                'todo' => 'BBB'
            ]
        ];

        $this->todolistService->saveTodo('1', 'AAA');
        $this->todolistService->saveTodo('2', 'BBB');

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1', 'AAA');
        $this->todolistService->saveTodo('2', 'BBB');

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('3');
        // var_dump($this->todolistService->getTodolist());

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('1');
        var_dump($this->todolistService->getTodolist());

        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo('2');
        var_dump($this->todolistService->getTodolist());

        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
        
    }
}
