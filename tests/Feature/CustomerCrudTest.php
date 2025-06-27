<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\FamilyContactPerson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_be_created(): void
    {
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $data = [
            'family_contact_persons_id' => $familyContactPerson->id,
            'amount_adults' => 2,
            'amount_children' => 1,
            'amount_babies' => 0,
            'special_wishes' => 'Geen',
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 1',
            'is_active' => true,
        ];
        $response = $this->post(route('customers.store'), $data);
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'family_name' => 'Testgezin',
            'address' => 'Teststraat 1',
        ]);
    }

    public function test_customer_can_be_edited(): void
    {
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $customer = Customer::factory()->create([
            'family_contact_persons_id' => $familyContactPerson->id,
            'family_name' => 'Oudgezin',
            'address' => 'Oudstraat 1',
        ]);
        $updateData = [
            'family_contact_persons_id' => $familyContactPerson->id,
            'amount_adults' => 3,
            'amount_children' => 2,
            'amount_babies' => 1,
            'special_wishes' => 'Vegetarisch',
            'family_name' => 'Nieuwgezin',
            'address' => 'Nieuwstraat 2',
            'is_active' => true,
        ];
        $response = $this->put(route('customers.update', $customer), $updateData);
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseHas('customers', [
            'family_name' => 'Nieuwgezin',
            'address' => 'Nieuwstraat 2',
        ]);
    }

    public function test_customer_can_be_deleted(): void
    {
        $familyContactPerson = FamilyContactPerson::factory()->create();
        $customer = Customer::factory()->create([
            'family_contact_persons_id' => $familyContactPerson->id,
        ]);
        $response = $this->delete(route('customers.destroy', $customer));
        $response->assertRedirect(route('customers.index'));
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
