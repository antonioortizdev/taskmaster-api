<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\Uri;

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
            'message' => 'Task with ID 8c5f1809-d190-4442-b77f-8063e6f350ff already exists',
        ]);
    }

    public function testIndexMethod()
    {
        $response = $this->call('GET', '/api/v1/tasks', []);
        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
