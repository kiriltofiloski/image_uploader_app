<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_request(){
        //Make fake image
        Storage::fake('public');
        $imageFile = UploadedFile::fake()->image('test.png');
        
        //Post test
        $response = $this->postJson('/api/upload', [
            'image' => $imageFile,
            'title' => 'Test Image',
            'description' => 'Test Description'
        ], [
            'Authorization' => env('IMAGE_UPLOAD_TOKEN')
        ]);
        

        //Assertions
        $this->assertEquals(201, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Image uploaded successfully', $responseData['message']);
    }

    public function test_missing_image(){
        //Post test
        $response = $this->postJson('/api/upload', [
            'title' => 'Test Image',
            'description' => 'Test Description'
        ], [
            'Authorization' => env('IMAGE_UPLOAD_TOKEN')
        ]);

        //Assertions
        $this->assertEquals(422, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Validation failed', $responseData['message']);
    }

    public function test_unauthorized_access(){
        //Make fake image
        Storage::fake('public');
        $imageFile = UploadedFile::fake()->image('test.png');

        //Post
        $response = $this->postJson('/api/upload', [
            'image' => $imageFile,
            'title' => 'Test Image',
            'description' => 'Test Description'
        ], [
            'Authorization' => 'incorrect-token'
        ]);

        // Assertions
        $this->assertEquals(401, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Unauthorized', $responseData['error']);
    }
}
