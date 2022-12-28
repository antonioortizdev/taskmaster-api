<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Http\Response;

class TaskControllerTest extends FeatureTestCase
{
    public function testStoreMethod()
    {
        $data = [
            'id' => '8c5f1809-d190-4442-b77f-8063e6f350ff',
            'name' => 'do the laundry',
            'status' => 2,
        ];

        $response = $this->call('POST', '/api/v1/tasks', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'id' => '8c5f1809-d190-4442-b77f-8063e6f350ff'
        ]);

        $response = $this->call('POST', '/api/v1/tasks', $data);
        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Task with ID 8c5f1809-d190-4442-b77f-8063e6f350ff already exists.',
        ]);
    }

    public function testIndexMethod()
    {
        $task1 = (new Task([
            'id' => 'c8f81724-5145-42d4-806f-8e510ac8a394',
            'name' => 'do the laundry',
            'status' => 1,
        ]))->save();
        $task2 = (new Task([
            'id' => '8333218a-7108-4ce9-b7a5-1f9e799d8471',
            'name' => 'do the laundry again',
            'status' => 2,
        ]))->save();
        $task3 = (new Task([
            'id' => '38948f89-cf35-4d9a-9add-932fa3129715',
            'name' => 'fix bug',
            'status' => 2,
        ]))->save();

        $response = $this->call('GET', '/api/v1/tasks', []);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([$task1, $task2, $task3]);

        $response = $this->call('GET', '/api/v1/tasks', ['status' => 1]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([$task1]);

        $response = $this->call('GET', '/api/v1/tasks', ['name' => 'do the laundry']);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([$task1, $task2]);

        $response = $this->call('GET', '/api/v1/tasks', ['id' => 'c8f81724-5145-42d4-806f-8e510ac8a394']);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([ 'message' => "Field 'id' is not a valid field." ]);
    }
}
