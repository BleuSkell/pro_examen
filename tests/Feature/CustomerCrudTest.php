<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\FamilyContactPerson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CustomerCrudTest extends TestCase
{
     use WithoutMiddleware; 
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Only disable CSRF protection for tests
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        // Recreate stored procedures after migrations
        \DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_create_customer;
            CREATE PROCEDURE sp_create_customer(
                IN p_family_contact_persons_id INT,
                IN p_amount_adults INT,
                IN p_amount_children INT,
                IN p_amount_babies INT,
                IN p_special_wishes VARCHAR(255),
                IN p_family_name VARCHAR(100),
                IN p_address VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                INSERT INTO customers (
                    family_contact_persons_id,
                    amount_adults,
                    amount_children,
                    amount_babies,
                    special_wishes,
                    family_name,
                    address,
                    is_active,
                    date_created,
                    date_updated
                ) VALUES (
                    p_family_contact_persons_id,
                    p_amount_adults,
                    p_amount_children,
                    p_amount_babies,
                    p_special_wishes,
                    p_family_name,
                    p_address,
                    p_is_active,
                    NOW(),
                    NOW()
                );
            END;
        ');
        \DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_get_customers;
            CREATE PROCEDURE sp_get_customers()
            BEGIN
                SELECT c.*, f.first_name as family_contact_first_name, f.infix as family_contact_infix, f.last_name as family_contact_last_name
                FROM customers c
                LEFT JOIN family_contact_persons f ON c.family_contact_persons_id = f.id
                ORDER BY c.date_created DESC;
            END;
        ');
        \DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_update_customer;
            CREATE PROCEDURE sp_update_customer(
                IN p_id INT,
                IN p_family_contact_persons_id INT,
                IN p_amount_adults INT,
                IN p_amount_children INT,
                IN p_amount_babies INT,
                IN p_special_wishes VARCHAR(255),
                IN p_family_name VARCHAR(100),
                IN p_address VARCHAR(255),
                IN p_is_active BOOLEAN
            )
            BEGIN
                UPDATE customers SET
                    family_contact_persons_id = p_family_contact_persons_id,
                    amount_adults = p_amount_adults,
                    amount_children = p_amount_children,
                    amount_babies = p_amount_babies,
                    special_wishes = p_special_wishes,
                    family_name = p_family_name,
                    address = p_address,
                    is_active = p_is_active,
                    date_updated = NOW()
                WHERE id = p_id;
            END;
        ');
        \DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_delete_customer;
            CREATE PROCEDURE sp_delete_customer(
                IN p_id INT
            )
            BEGIN
                DELETE FROM customers WHERE id = p_id;
            END;
        ');
    }

    public function test_customer_can_be_created(): void
    {
        $this->withoutExceptionHandling();
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
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        
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
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        
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