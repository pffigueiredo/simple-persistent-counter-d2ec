<?php

use App\Models\Counter;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('displays the counter page with initial count', function () {
    // Ensure no counter exists yet
    Counter::truncate();
    
    $response = get('/');
    
    $response->assertStatus(200)
             ->assertInertia(fn ($page) => $page
                 ->component('welcome')
                 ->has('count')
                 ->where('count', 0)
             );
});

it('increments the counter when store route is called', function () {
    // Create initial counter
    Counter::create(['count' => 5]);
    
    $response = post('/counter');
    
    $response->assertStatus(200)
             ->assertInertia(fn ($page) => $page
                 ->component('welcome')
                 ->where('count', 6)
             );
    
    // Verify database was updated
    expect(Counter::first()->count)->toBe(6);
});

it('creates a new counter if none exists when incrementing', function () {
    // Ensure no counter exists
    Counter::truncate();
    
    $response = post('/counter');
    
    $response->assertStatus(200)
             ->assertInertia(fn ($page) => $page
                 ->component('welcome')
                 ->where('count', 1)
             );
    
    // Verify counter was created
    expect(Counter::count())->toBe(1);
    expect(Counter::first()->count)->toBe(1);
});

it('persists counter value across multiple requests', function () {
    Counter::truncate();
    
    // First increment
    post('/counter');
    expect(Counter::first()->count)->toBe(1);
    
    // Second increment
    post('/counter');
    expect(Counter::first()->count)->toBe(2);
    
    // Third increment
    post('/counter');
    expect(Counter::first()->count)->toBe(3);
    
    // Verify GET request shows correct count
    $response = get('/');
    $response->assertInertia(fn ($page) => $page->where('count', 3));
});