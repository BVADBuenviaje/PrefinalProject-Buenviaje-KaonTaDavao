<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');
        $response->assertStatus(200);

        $eateriesResponse = $this->get('/eateries');
        $eateriesResponse->assertStatus(200);

        $districtsResponse = $this->get('/districts');
        $districtsResponse->assertStatus(200);

        $eatery = Eatery::first();
        $showResponse = $this->get('/eateries/' . $eatery->slug);
        $showResponse->assertStatus(200);
    }

    public function test_form_validations_and_messages(): void
    {
        $this->seed();

        // 1. Unique name
        $existing = Eatery::first();
        $response = $this->post('/eateries', [
            'name' => $existing->name,
            'district_id' => 1,
            'address' => 'Test address',
            'price_range' => 'budget',
            'is_open' => '1',
            'features' => [1],
            'permit_no' => 'DVO-2026-99999',
            'expires_on' => '2028-01-01',
        ]);
        $response->assertSessionHasErrors([
            'name' => 'Kaon Ta Buenviaje already lists an eatery with this name.',
        ]);

        // 2. Features required
        $response = $this->post('/eateries', [
            'name' => 'Brand New Name',
            'district_id' => 1,
            'address' => 'Test address',
            'price_range' => 'budget',
            'is_open' => '1',
            'permit_no' => 'DVO-2026-99998',
            'expires_on' => '2028-01-01',
        ]);
        $response->assertSessionHasErrors([
            'features' => 'Pick at least one feature.',
        ]);

        // 3. Permit regex
        $response = $this->post('/eateries', [
            'name' => 'Brand New Name',
            'district_id' => 1,
            'address' => 'Test address',
            'price_range' => 'budget',
            'is_open' => '1',
            'features' => [1],
            'permit_no' => 'INVALID-123',
            'expires_on' => '2028-01-01',
        ]);
        $response->assertSessionHasErrors([
            'permit_no' => 'Permit number must look like DVO-2026-0415.',
        ]);

        // 4. Expires on after today
        $response = $this->post('/eateries', [
            'name' => 'Brand New Name',
            'district_id' => 1,
            'address' => 'Test address',
            'price_range' => 'budget',
            'is_open' => '1',
            'features' => [1],
            'permit_no' => 'DVO-2026-99997',
            'expires_on' => '2020-01-01',
        ]);
        $response->assertSessionHasErrors([
            'expires_on' => 'The permit must not be expired.',
        ]);

        // 5. Review validations
        $openEatery = Eatery::where('is_open', true)->first();
        $response = $this->post("/eateries/{$openEatery->slug}/reviews", [
            'rating' => 0,
            'body' => 'short',
        ]);
        $response->assertSessionHasErrors([
            'user_id' => 'Choose who is writing this review.',
            'rating' => 'Ratings go from 1 to 5 stars only.',
            'body' => 'Kaon Ta Buenviaje: reviews need at least 10 characters.',
        ]);

        // 6. Reviewing closed eatery returns 403
        $closedEatery = Eatery::where('is_open', false)->first();
        $user = User::first();
        $response = $this->post("/eateries/{$closedEatery->slug}/reviews", [
            'user_id' => $user->id,
            'rating' => 5,
            'body' => 'Should not be allowed because eatery is closed.',
        ]);
        $response->assertStatus(403);
    }
}
