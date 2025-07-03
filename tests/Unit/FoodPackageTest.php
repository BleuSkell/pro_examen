<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\FoodPackage;
use App\Models\Customer;
use App\Models\FoodPackageProduct;
use App\Models\Product;
use App\Models\ProductCategory;

class FoodPackageTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_fetches_food_packages_with_all_relations()
    {
        // Arrange: maak een food package met alle benodigde relaties
        $category = ProductCategory::factory()->create();
        $product = Product::factory()->create(['product_category_id' => $category->id]);
        $customer = Customer::factory()->create();
        $foodPackage = FoodPackage::factory()->create(['customer_id' => $customer->id]);
        $foodPackageProduct = FoodPackageProduct::factory()->create([
            'food_package_id' => $foodPackage->id,
            'product_id' => $product->id,
        ]);

        // Act: haal het food package op met alle relaties
        $result = FoodPackage::with([
            'customer',
            'foodPackageProducts.product.productCategory'
        ])->find($foodPackage->id);

        // Assert: check of alles geladen is
        $this->assertNotNull($result->customer);
        $this->assertCount(1, $result->foodPackageProducts);
        $this->assertEquals($product->id, $result->foodPackageProducts[0]->product->id);
        $this->assertEquals($category->id, $result->foodPackageProducts[0]->product->productCategory->id);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_food_package_with_relations()
    {
        // Arrange: maak een customer en product
        $customer = Customer::factory()->create();
        $product = Product::factory()->create();

        // Act: maak een food package aan
        $foodPackage = FoodPackage::factory()->create([
            'customer_id' => $customer->id,
            'package_number' => 'P-12345',
            'date_composed' => now(),
            'is_active' => true,
        ]);

        // Voeg een product toe aan de food package
        $foodPackageProduct = FoodPackageProduct::factory()->create([
            'food_package_id' => $foodPackage->id,
            'product_id' => $product->id,
        ]);

        // Assert: controleer of de food package is aangemaakt met de juiste relaties
        $this->assertDatabaseHas('food_packages', [
            'id' => $foodPackage->id,
            'customer_id' => $customer->id,
            'package_number' => 'P-12345',
            'is_active' => true,
        ]);
        $this->assertCount(1, $foodPackage->foodPackageProducts);
        $this->assertEquals($product->id, $foodPackage->foodPackageProducts[0]->product_id);
    }
    
    #[\PHPUnit\Framework\Attributes\Test]
    public function test_it_updates_food_package()
    {
        // Arrange: maak een food package
        $foodPackage = FoodPackage::factory()->create([
            'package_number' => 'P-12345',
            'is_active' => true,
        ]);

        // Act: update de food package
        $foodPackage->update([
            'package_number' => 'P-54321',
            'is_active' => false,
        ]);

        // Assert: controleer of de update is doorgevoerd
        $this->assertDatabaseHas('food_packages', [
            'id' => $foodPackage->id,
            'package_number' => 'P-54321',
            'is_active' => false,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_it_deletes_food_package()
    {
        // Arrange: maak een food package
        $foodPackage = FoodPackage::factory()->create();

        // Act: verwijder de food package
        $foodPackage->delete();

        // Assert: controleer of de food package is verwijderd
        $this->assertDatabaseMissing('food_packages', [
            'id' => $foodPackage->id,
        ]);
    }
}