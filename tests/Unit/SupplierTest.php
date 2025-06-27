<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Supplier;
use App\Models\ContactPerson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_supplier_has_a_contact_person()
    {
        // Hier maak je een contact persoon aan 
        $contactPerson = ContactPerson::factory()->create();

        // Act: maak een supplier aan die gekoppeld is aan deze contactpersoon
        $supplier = Supplier::factory()->create([
            'contact_person_id' => $contactPerson->id,
        ]);

        // Assert: controleer of de relatie werkt
        $this->assertInstanceOf(ContactPerson::class, $supplier->contactPerson);
        $this->assertEquals($contactPerson->id, $supplier->contactPerson->id);
    }
}
