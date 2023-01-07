<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testItReturnsOkResponseWhenStoringTask()
    {
        $requestData = [
            'id' => '8c5f1809-d190-4442-b77f-8063e6f350ff',
            'name' => 'do the laundry',
            'status' => 2,
        ];

        $response = $this->call('POST', '/api/v1/tasks', $requestData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'id' => '8c5f1809-d190-4442-b77f-8063e6f350ff'
        ]);
    }

    public function testItReturnsBadRequestResponseWhenStoringExistentTask()
    {
        $task1 = new Task([
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 2,
        ]);
        $task1->save();
        $requestData = [
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 2,
        ];

        $response = $this->json('POST', '/api/v1/tasks', $requestData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'message' => 'Task with ID c8f81724-5145-42d4-806f-8e510ac8a394 already exists.',
        ]);
    }

    public function testItReturnsOkResponseWhenSearchingTasksByStatus()
    {
        $task1 = new Task([
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 1,
        ]);
        $task1->save();
        $task2 = new Task([
            'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
            'name' => 'do the laundry again',
            'status' => 2,
        ]);
        $task2->save();
        $task3 = new Task([
            'id' => '38948f89-cf35-4d9a-9add-932fa3129715',
            'name' => 'fix bug',
            'status' => 2,
        ]);
        $task3->save();
        $requestData = [
            'status' => 2,
        ];

        $response = $this->json('GET', '/api/v1/tasks', $requestData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            [
                'id' => '38948f89-cf35-4d9a-9add-932fa3129715',
                'name' => 'fix bug',
                'status' => 2,
            ],
            [
                'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
                'name' => 'do the laundry again',
                'status' => 2,
            ],
        ]);
    }

    public function testItReturnsOkResponseWhenSearchingTasksByName()
    {
        $task1 = new Task([
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 1,
        ]);
        $task1->save();
        $task2 = new Task([
            'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
            'name' => 'do the laundry again',
            'status' => 2,
        ]);
        $task2->save();
        $task3 = new Task([
            'id' => '38948f89-cf35-4d9a-9add-932fa3129715',
            'name' => 'fix bug',
            'status' => 2,
        ]);
        $task3->save();
        $requestData = [
            'name' => 'do the laundry',
        ];

        $response = $this->json('GET', '/api/v1/tasks', $requestData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            [
                'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
                'name' => 'do the laundry again',
                'status' => 2,
            ],
            [
                'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
                'name' => 'do the laundry',
                'status' => 1,
            ],
        ]);
    }

    public function testItReturnsBadRequestResponseWhenSearchingTasksWithInvalidData()
    {
        $task1 = new Task([
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 1,
        ]);
        $task1->save();
        $task2 = new Task([
            'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
            'name' => 'do the laundry again',
            'status' => 2,
        ]);
        $task2->save();
        $task3 = new Task([
            'id' => '38948f89-cf35-4d9a-9add-932fa3129715',
            'name' => 'fix bug',
            'status' => 2,
        ]);
        $task3->save();
        $requestData = [
            'invalid_field' => $this->faker->word,
        ];

        $response = $this->json('GET', '/api/v1/tasks', $requestData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'message' => 'Field \'invalid_field\' is not a valid field.',
        ]);
    }
}
