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

    /** @test */
    public function it_fetches_food_packages_with_all_relations()
    {
        // Arrange: maak een food package met alle relaties
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
}