<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

const REGISTER_ENDPOINT = '/api/v1/auth/register';
const API_KEY = 'test-api-key';

beforeEach(function () {
    config(['app.api_key' => API_KEY]);
});

function validRegistrationData(): array
{
    return [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Xy7!qR9@Lm2#Vt8$Kp4',
    ];
}

test('user can register through the API', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertCreated();

    $response->assertJson([
        'message' => 'The user has been created',
    ]);

    $response->assertJsonStructure([
        'message',
        'token',
    ]);

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'slug' => 'john-doe',
    ]);
});

test('registration returns an authentication token', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertCreated();

    expect($response->json('token'))
        ->toBeString()
        ->not->toBeEmpty();
});

test('registration creates a personal access token', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertCreated();

    $user = User::where('email', 'john@example.com')->first();

    $this->assertDatabaseHas('personal_access_tokens', [
        'tokenable_type' => User::class,
        'tokenable_id' => $user->id,
        'name' => 'token',
    ]);
});

test('registration hashes the password', function () {
    $password = validRegistrationData()['password'];

    $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, [
        ...validRegistrationData(),
        'password' => $password,
    ])->assertCreated();

    $user = User::where('email', 'john@example.com')->first();

    expect($user->password)
        ->not->toBe($password);

    expect(Hash::check($password, $user->password))
        ->toBeTrue();
});

test('registration generates slug from name', function () {
    $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, [
        ...validRegistrationData(),
        'name' => 'John Doe',
    ])->assertCreated();

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'slug' => 'john-doe',
    ]);
});

test('registration generates a unique slug when slug already exists', function () {
    User::factory()->create([
        'slug' => 'john-doe',
    ]);

    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertCreated();

    $user = User::where('email', 'john@example.com')->first();

    expect($user->slug)
        ->not->toBe('john-doe')
        ->toStartWith('john-doe-');
});

test('registration rejects duplicate email', function () {
    User::factory()->create([
        'email' => 'john@example.com',
    ]);

    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertUnprocessable();

    $this->assertDatabaseCount('users', 1);
});

test('registration rejects duplicate slug', function () {
    User::factory()->create([
        'slug' => 'my-slug',
    ]);

    $response = $this->withHeader(
        'X-API-KEY',
        API_KEY
    )->postJson(REGISTER_ENDPOINT, [
        ...validRegistrationData(),
        'slug' => 'my-slug',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrors([
        'slug',
    ]);

    $this->assertDatabaseCount('users', 1);
});

test('registration rejects invalid api key', function () {
    $response = $this->withHeader(
        'X-API-KEY',
        'wrong-api-key'
    )->postJson(REGISTER_ENDPOINT, validRegistrationData());

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Unauthorized access.',
    ]);

    $this->assertDatabaseCount('users', 0);
});

test('registration rejects request without api key', function () {
    $response = $this->postJson(
        REGISTER_ENDPOINT,
        validRegistrationData()
    );

    $response->assertUnauthorized();

    $response->assertJson([
        'message' => 'Unauthorized access.',
    ]);

    $this->assertDatabaseCount('users', 0);
});