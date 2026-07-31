<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_registration_succeeds_with_valid_data()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'firstname'            => 'John',
            'lastname'             => 'Doe',
            'email'                => 'johndoe@example.com',
            'username'             => 'johndoe',
            'password'             => 'password123',
            'password_confirmation'=> 'password123',
            'contact_no'           => '09123456789',
            'address_barangay'     => 'San Vicente',
            'address_municipality' => 'Bantayan',
            'address_province'     => 'Cebu',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                 ]);

        $this->assertDatabaseHas('clients', [
            'email'    => 'johndoe@example.com',
            'username' => 'johndoe',
        ]);
    }

    public function test_api_registration_fails_on_validation_errors()
    {
        // 1. Test missing required fields
        $response = $this->postJson('/api/v1/auth/register', [
            'firstname' => 'John',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'lastname', 'email', 'username', 'password', 'contact_no', 
                     'address_barangay', 'address_municipality', 'address_province'
                 ]);

        // 2. Test duplicate email/username
        \App\Models\Client::create([
            'firstname'            => 'Existing',
            'lastname'             => 'User',
            'email'                => 'johndoe@example.com',
            'username'             => 'johndoe',
            'password'             => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);

        $response2 = $this->postJson('/api/v1/auth/register', [
            'firstname'            => 'John',
            'lastname'             => 'Doe',
            'email'                => 'johndoe@example.com',
            'username'             => 'johndoe',
            'password'             => 'password123',
            'password_confirmation'=> 'password123',
            'contact_no'           => '09123456789',
            'address_barangay'     => 'San Vicente',
            'address_municipality' => 'Bantayan',
            'address_province'     => 'Cebu',
        ]);

        $response2->assertStatus(422)
                  ->assertJsonValidationErrors(['email', 'username']);
    }
}
