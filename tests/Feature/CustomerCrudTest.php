<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\FamilyContactPerson;
use App\Models\User;
use App\Models\Role;

class CustomerCrudTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Optionally seed required data
        // $this->artisan('db:seed');
    }

    public function test_create_customer()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        $familyContactPerson = FamilyContactPerson::factory()->create();

        $postData = [
            'family_contact_persons_id' => $familyContactPerson->id,
            'amount_adults' => 2,
            'amount_children' => 1,
            'amount_babies' => 0,
            'special_wishes' => 'No peanuts',
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 123',
            'is_active' => 1,
        ];
        $response = $this->post(route('customers.store'), $postData);
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 123',
        ]);
    }

    public function test_read_customers()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $customer = Customer::factory()->create([
            'family_contact_persons_id' => $familyContactPerson->id,
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 123',
        ]);

        $response = $this->get(route('customers.index'));
        $response->assertStatus(200);
        $response->assertSee('Testgezin');
    }

    public function test_update_customer()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $customer = Customer::factory()->create([
            'family_contact_persons_id' => $familyContactPerson->id,
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 123',
            'is_active' => 1,
        ]);

        $updateData = [
            'family_contact_persons_id' => $familyContactPerson->id,
            'amount_adults' => 3,
            'amount_children' => 2,
            'amount_babies' => 1,
            'special_wishes' => 'No nuts',
            'family_name' => 'Testgezin Gewijzigd',
            'address' => 'Teststraat 123',
            // 'is_active' => 0, // omit to simulate unchecked checkbox
        ];
        $response = $this->put(route('customers.update', $customer), $updateData);
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'family_name' => 'Testgezin Gewijzigd',
            'amount_adults' => 3,
            'is_active' => 0,
        ]);
    }

    public function test_delete_customer()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $customer = Customer::factory()->create([
            'family_contact_persons_id' => $familyContactPerson->id,
            'address' => 'Teststraat 123',
        ]);

        $response = $this->delete(route('customers.destroy', $customer));
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseMissing('customers', [
            'address' => 'Teststraat 123',
        ]);
    }
}
