<?php

namespace Tests\Feature;

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
            'status' => 200,
            'message' => 'New task created successfully!',
            'data' => [ 'id' => '8c5f1809-d190-4442-b77f-8063e6f350ff' ],
        ]);

        $response = $this->call('POST', '/api/v1/tasks', $data);
        $response->assertStatus(500);
    }
}
