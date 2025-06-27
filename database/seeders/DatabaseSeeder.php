<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\FamilyContactPerson;
use App\Models\Customer;
use App\Models\ProductCategory;
use App\Models\ContactPerson;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Stock;
use App\Models\FoodPackage;
use App\Models\FoodPackageProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles (exact 4, geen duplicaten)
        $roles = [
            ['role_name' => 'Guest', 'date_created' => now(), 'date_updated' => now(), 'is_active' => true],
            ['role_name' => 'Director', 'date_created' => now(), 'date_updated' => now(), 'is_active' => true],
            ['role_name' => 'Warehouse worker', 'date_created' => now(), 'date_updated' => now(), 'is_active' => true],
            ['role_name' => 'Volunteer', 'date_created' => now(), 'date_updated' => now(), 'is_active' => true],
        ];
        Role::insert($roles);
        $roleIds = Role::pluck('id')->toArray();

        // 2. Users (10, verdeeld over de 3 rollen)
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
            'role_id' => $roleIds[$i % 3],
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Str::random(10),
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
            ];
        }

        // Extra users: 1 director, 1 warehouse worker, 1 volunteer
        $users[] = [
            'role_id' => $roleIds[1], // Director
            'name' => 'Director User',
            'email' => 'director@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Str::random(10),
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
        ];
        $users[] = [
            'role_id' => $roleIds[2], // Warehouse worker
            'name' => 'Warehouse Worker User',
            'email' => 'warehouse@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Str::random(10),
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
        ];
        $users[] = [
            'role_id' => $roleIds[3], // Volunteer
            'name' => 'Volunteer User',
            'email' => 'volunteer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => \Str::random(10),
            'date_created' => now(),
            'date_updated' => now(),
            'is_active' => true,
        ];

        User::insert($users);

        // 3. Family contact persons (10)
        $familyContactPersons = FamilyContactPerson::factory(10)->create();

        // 4. Customers (10, elk gebruikt één family contact person)
        $customers = [];
        foreach ($familyContactPersons as $fcp) {
            $customers[] = [
                'family_contact_persons_id' => $fcp->id,
                'amount_adults' => fake()->numberBetween(1, 4),
                'amount_children' => fake()->numberBetween(0, 4),
                'amount_babies' => fake()->numberBetween(0, 2),
                'special_wishes' => fake()->optional()->randomElement(['Geen varken', 'Gluten', 'Vegetarisch', 'Veganistisch', 'Geen noten', 'Geen zuivel']),
                'family_name' => $fcp->last_name,
                'address' => fake()->address(),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        Customer::insert($customers);
        $customerIds = Customer::pluck('id')->toArray();

        // 5. Product categories (exact 9, vaste namen)
        $categoryNames = ['Groenten', 'Fruit', 'Vlees', 'Vis', 'Zuivel', 'Granen', 'Dranken', 'Snacks', 'Overig'];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[] = [
                'category_name' => $name,
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        ProductCategory::insert($categories);
        $categoryIds = ProductCategory::pluck('id')->toArray();

        // 6. Contact persons (10)
        $contactPersons = ContactPerson::factory(10)->create();

        // 7. Suppliers (10, elk gebruikt één contact person)
        $suppliers = [];
        foreach ($contactPersons as $cp) {
            $suppliers[] = [
                'contact_person_id' => $cp->id,
                'company_name' => fake()->company(),
                'address' => fake()->address(),
                'next_delivery_date' => fake()->dateTimeBetween('now', '+1 month'),
                'next_delivery_time' => fake()->time(),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        Supplier::insert($suppliers);
        $supplierIds = Supplier::pluck('id')->toArray();

        // 8. Products (10, elke product gebruikt 1 van de 9 categorieën, supplier kan meerdere producten leveren)
        $products = [];
        for ($i = 0; $i < 10; $i++) {
            $products[] = [
                'product_category_id' => $categoryIds[$i % 9],
                'supplier_id' => $supplierIds[array_rand($supplierIds)],
                'product_name' => fake()->word(),
                'barcode' => fake()->unique()->ean13(),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        Product::insert($products);
        $productIds = Product::pluck('id')->toArray();

        // 8b. Stocks (voor elk product een voorraadregel)
        $stocks = [];
        foreach ($productIds as $productId) {
            $stocks[] = [
                'product_id' => $productId,
                'amount' => fake()->numberBetween(0, 1000),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        Stock::insert($stocks);

        // 9. FoodPackages (10, elk voor 1 customer)
        $foodPackages = [];
        foreach ($customerIds as $i => $customerId) {
            $foodPackages[] = [
                'customer_id' => $customerId,
                'package_number' => 'P-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'date_composed' => now()->subDays(rand(0, 10)),
                'date_issued' => now()->subDays(rand(0, 5)),
                'date_created' => now(),
                'date_updated' => now(),
                'is_active' => true,
            ];
        }
        FoodPackage::insert($foodPackages);
        $foodPackageIds = FoodPackage::pluck('id')->toArray();

        // 10. FoodPackageProducts (koppel elk pakket aan 2-4 random producten)
        foreach ($foodPackageIds as $foodPackageId) {
            $randomProducts = collect($productIds)->random(rand(2, 4));
            foreach ($randomProducts as $productId) {
                FoodPackageProduct::create([
                    'food_package_id' => $foodPackageId,
                    'product_id' => $productId,
                    'amount' => fake()->numberBetween(1, 10),
                    'date_created' => now(),
                    'date_updated' => now(),
                    'is_active' => true,
                ]);
            }
        }
    }
}
