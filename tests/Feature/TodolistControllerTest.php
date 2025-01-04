<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'thariq',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'belajar'
                ],
                [
                    'id' => '2',
                    'todo' => 'makan'
                ],
            ]
        ])->get('/todolist')
            ->assertSeeText('todolist')
            ->assertSeeText('1')
            ->assertSeeText('belajar')
            ->assertSeeText('2')
            ->assertSeeText('makan');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'thariq'
        ])->post('/todolist', [
            'todo' => 'makan'
        ])->assertRedirect('/todolist');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'thariq'
        ])->post('/todolist', [])
            ->assertSeeText('todo can not blank');
        
            /**redirect tidak menampilan isi
             * view menampilkan isi. 
             * kelihatan perbedaannya ketika testing
             */
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            'user' => 'thariq',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'belajar'
                ],
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
