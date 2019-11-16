<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanCreateTask()
    {
        $this->withoutExceptionHandling();

        // Что, входные данные: Авторизованные пользователь
        $this->actingAs($user = factory(\App\User::class)->create());

        // Когда: Проходит на страницу /tasks для создания новой задачи, передавая необходимые данные
        $attributes = factory(Task::class)->raw(['owner_id' => $user]);
        $this->post('/tasks', $attributes);

        // Что в итоге: Запись в БД о новой задаче
        $this->assertDatabaseHas('tasks', $attributes);
    }

    public function testGuestMayNotCreateATask()
    {
        $this->post('/tasks', [])->assertRedirect('/login');

    }
}
