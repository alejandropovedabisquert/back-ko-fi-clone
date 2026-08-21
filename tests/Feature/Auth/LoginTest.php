<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

const LOGIN_ENDPOINT = '/api/v1/auth/login';
const API_KEY = 'test-api-key';

beforeEach(function () {
    config(['app.api_key' => API_KEY]);
});

test('user can login with valid credentials', function () {
    User::factory()->create([
        'email' => 'john@example.com',
        'name' => 'john',
        'slug' => 'john-doe',
        'password' => Hash::make('Password123!'),
    ]);

    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'john@example.com',
        'password' => 'Password123!',
    ]);

    $response->assertOk();

    $response->assertJsonStructure([
        'token',
        'user',
    ]);
});

test('login fails with invalid password', function () {
    User::factory()->create([
        'email' => 'john@example.com',
        'name' => 'john',
        'slug' => 'john-doe',
        'password' => Hash::make('Password123!'),
    ]);

    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'john@example.com',
        'password' => 'WrongPassword123!',
    ]);

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Invalid credentials',
    ]);
});

test('login fails with non existing email', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'doesnotexist@example.com',
        'password' => 'Password123!',
    ]);

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Invalid credentials',
    ]);
});

test('login requires email', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'password' => 'Password123!',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrors([
        'email',
    ]);
});

test('login rejects invalid email format', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'not-an-email',
        'password' => 'Password123!',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrors([
        'email',
    ]);
});

test('login requires password', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'john@example.com',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrors([
        'password',
    ]);
});

test('login requires api key', function () {
    $response = $this->postJson(LOGIN_ENDPOINT, [
        'email' => 'john@example.com',
        'password' => 'Password123!',
    ]);

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Unauthorized access.',
    ]);
});

test('login rejects invalid api key', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        'wrong-api-key'
    )->postJson(LOGIN_ENDPOINT, [
        'email' => 'john@example.com',
        'password' => 'Password123!',
    ]);

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Unauthorized access.',
    ]);
});
