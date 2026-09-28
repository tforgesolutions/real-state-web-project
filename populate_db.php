<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Property;
use App\Models\Project;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\Amenity;
use App\Models\Inquiry;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::beginTransaction();

try {
    echo "Starting Data Population...\n";

    // 1. LOCATIONS
    $locationsData = ['Lahore', 'Islamabad', 'Karachi', 'Rawalpindi', 'Faisalabad'];
    $locations = [];
    foreach ($locationsData as $loc) {
        $locations[] = Location::firstOrCreate(
            ['name' => $loc],
            ['type' => 'City', 'status' => 'Active', 'description' => "Explore premium properties in $loc."]
        );
    }
    echo "Created " . count($locations) . " Locations.\n";

    // 2. PROPERTY TYPES
    $typesData = ['House', 'Apartment', 'Commercial', 'Plot', 'Villa'];
    $propertyTypes = [];
    foreach ($typesData as $type) {
        $propertyTypes[] = PropertyType::firstOrCreate(
            ['name' => $type],
            ['status' => 'Active', 'slug' => Str::slug($type)]
        );
    }
    echo "Created " . count($propertyTypes) . " Property Types.\n";

    // 3. AMENITIES
    $amenitiesData = ['Parking', 'Swimming Pool', 'Security', 'Backup Electricity', 'Gym', 'CCTV', 'Balcony', 'Garden'];
    $amenities = [];
    foreach ($amenitiesData as $amenity) {
        $amenities[] = Amenity::firstOrCreate(
            ['name' => $amenity],
            ['status' => 'Active', 'icon' => 'check', 'slug' => Str::slug($amenity)] // fallback icon
        );
    }
    echo "Created " . count($amenities) . " Amenities.\n";

    // 4. AGENTS
    $agentsData = [
        ['name' => 'Michael Scott', 'email' => 'michael.scott@example.com', 'phone' => '555-0101'],
        ['name' => 'Dwight Schrute', 'email' => 'dwight.schrute@example.com', 'phone' => '555-0102'],
        ['name' => 'Jim Halpert', 'email' => 'jim.halpert@example.com', 'phone' => '555-0103'],
        ['name' => 'Pam Beesly', 'email' => 'pam.beesly@example.com', 'phone' => '555-0104'],
        ['name' => 'Ryan Howard', 'email' => 'ryan.howard@example.com', 'phone' => '555-0105'],
    ];
    $agents = [];
    foreach ($agentsData as $agent) {
        $agents[] = User::firstOrCreate(
            ['email' => $agent['email']],
            [
                'name' => $agent['name'],
                'phone' => $agent['phone'],
                'role' => 'agent',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
    echo "Created " . count($agents) . " Agents.\n";

    // 5. CUSTOMERS (Users)
    $usersData = [
        ['name' => 'John Doe', 'email' => 'john.doe@example.com'],
        ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
        ['name' => 'Bob Johnson', 'email' => 'bob.johnson@example.com'],
        ['name' => 'Alice Brown', 'email' => 'alice.brown@example.com'],
        ['name' => 'Charlie Davis', 'email' => 'charlie.davis@example.com'],
    ];
    $customers = [];
    foreach ($usersData as $user) {
        $customers[] = User::firstOrCreate(
            ['email' => $user['email']],
            [
                'name' => $user['name'],
                'role' => 'user',
                'status' => 'active',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
    echo "Created " . count($customers) . " Customers.\n";

    // Fake external images handling logic (using local copies or absolute URLs if supported)
    // To be safe with `Storage::url`, we will download dummy images.
    Storage::disk('public')->makeDirectory('properties');
    Storage::disk('public')->makeDirectory('projects');
    
    // We will just use the fact that if it doesn't exist, we fallback in the view. But let's create a dummy file.
    if(!Storage::disk('public')->exists('properties/dummy.jpg')){
        Storage::disk('public')->put('properties/dummy.jpg', file_get_contents('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=800&auto=format&fit=crop'));
    }

    // 6. PROPERTIES
    $propertiesData = [
        ['title' => 'Luxury Villa in DHA', 'purpose' => 'sale', 'price' => 50000000, 'bedrooms' => 5, 'bathrooms' => 6, 'area' => 4500, 'type' => 'Villa', 'loc' => 'Lahore'],
        ['title' => 'Modern Apartment F-11', 'purpose' => 'rent', 'price' => 150000, 'bedrooms' => 3, 'bathrooms' => 3, 'area' => 1800, 'type' => 'Apartment', 'loc' => 'Islamabad'],
        ['title' => 'Commercial Plaza Main Blvd', 'purpose' => 'sale', 'price' => 250000000, 'bedrooms' => 0, 'bathrooms' => 10, 'area' => 10000, 'type' => 'Commercial', 'loc' => 'Karachi'],
        ['title' => 'Cozy House in Bahria Town', 'purpose' => 'rent', 'price' => 80000, 'bedrooms' => 4, 'bathrooms' => 4, 'area' => 2200, 'type' => 'House', 'loc' => 'Rawalpindi'],
        ['title' => '10 Marla Corner Plot', 'purpose' => 'sale', 'price' => 12000000, 'bedrooms' => 0, 'bathrooms' => 0, 'area' => 2250, 'type' => 'Plot', 'loc' => 'Faisalabad'],
    ];

    $properties = [];
    foreach ($propertiesData as $idx => $p) {
        $loc = Location::where('name', $p['loc'])->first();
        $agent = $agents[$idx % count($agents)];
        
        $prop = Property::firstOrCreate(
            ['title' => $p['title']],
            [
                'reference_id' => 'PROP-' . strtoupper(Str::random(8)),
                'reference_id' => 'PROJ-' . strtoupper(Str::random(8)), 'slug' => Str::slug($p['title']) . '-' . time(),
                'description' => "A beautiful " . strtolower($p['type']) . " located in the heart of " . $p['loc'] . ". Perfect for your needs with excellent amenities and prime location.",
                'property_type' => $p['type'], 'property_category' => 'residential', 'area_unit' => 'Sq. Ft.', 'area_locality' => 'Downtown', 'contact_name' => 'Sales Team', 'contact_phone' => '1234567890', 'contact_email' => 'sales@example.com',
                'purpose' => $p['purpose'],
                'status' => 'approved',
                'price' => $p['price'],
                'currency' => 'PKR',
                'bedrooms' => $p['bedrooms'],
                'bathrooms' => $p['bathrooms'],
                'area' => $p['area'],
                'city' => $p['loc'],
                'address' => 'Sample Address, ' . $p['loc'],
                'user_id' => $agent->id, // Assign to agent
                'location_id' => $loc->id,
                'is_featured' => $idx % 2 == 0 ? 1 : 0,
                'images' => ['properties/dummy.jpg'] // Assigned dummy image
            ]
        );
        $properties[] = $prop;

        // Sync Amenities (random 3)
        $prop->amenitiesRelation()->sync($amenities[0]->id);
        $prop->amenitiesRelation()->syncWithoutDetaching($amenities[1]->id);
        $prop->amenitiesRelation()->syncWithoutDetaching($amenities[2]->id);
    }
    echo "Created " . count($properties) . " Properties.\n";

    // 7. PROJECTS
    $projectsData = [
        ['title' => 'Skyline Heights', 'city' => 'Islamabad', 'status' => 'Ongoing'],
        ['title' => 'Ocean View Residencia', 'city' => 'Karachi', 'status' => 'Available'],
        ['title' => 'Green Valley Estate', 'city' => 'Lahore', 'status' => 'Upcoming'],
        ['title' => 'Twin City Towers', 'city' => 'Rawalpindi', 'status' => 'Completed'],
        ['title' => 'Industrial Park', 'city' => 'Faisalabad', 'status' => 'Available'],
    ];
    $projects = [];
    foreach ($projectsData as $idx => $p) {
        $loc = Location::where('name', $p['city'])->first();
        $proj = Project::firstOrCreate(
            ['title' => $p['title']],
            [
                'reference_id' => 'PROJ-' . strtoupper(Str::random(8)), 'slug' => Str::slug($p['title']) . '-' . time(),
                'description' => "A premium real estate project offering exceptional returns and luxurious living standards in " . $p['city'] . ".",
                'developer_name' => 'Elite Developers Ltd.',
                'city' => $p['city'],
                'address' => 'Main Boulevard, ' . $p['city'],
                'status' => $p['status'],
                'starting_price' => 5000000 + ($idx * 1000000),
                'is_featured' => 1,
                'location_id' => $loc->id,
                'images' => ['properties/dummy.jpg'] // using same dummy image
            ]
        );
        $projects[] = $proj;
    }
    echo "Created " . count($projects) . " Projects.\n";

    // 8. INQUIRIES
    $inquiries = [];
    for($i = 0; $i < 5; $i++) {
        $cust = $customers[$i % count($customers)];
        $prop = $properties[$i % count($properties)];
        $agent = User::find($prop->user_id);
        
        $inquiries[] = Inquiry::create([
            'name' => $cust->name,
            'email' => $cust->email,
            'phone' => '1234567890',
            'subject' => 'Interested in ' . $prop->title,
            'message' => 'Please provide more details about this property. I would like to schedule a viewing.',
            'inquiry_type' => 'Property',
            'status' => 'New',
            'property_id' => $prop->id,
            'agent_id' => $agent->id,
            'user_id' => $cust->id,
            'ip_address' => '127.0.0.1'
        ]);
    }
    echo "Created 5 Inquiries.\n";

    // 9. TESTIMONIALS
    $testis = [
        ['name' => 'Sarah Connor', 'role' => 'Home Buyer', 'content' => 'The best real estate experience I have ever had. The agents were incredibly helpful.'],
        ['name' => 'John Wick', 'role' => 'Investor', 'content' => 'Excellent portfolio of commercial properties. Highly recommend their services for serious investors.'],
        ['name' => 'Bruce Wayne', 'role' => 'Property Seller', 'content' => 'Sold my mansion in record time. Their marketing strategies are top-notch.'],
        ['name' => 'Clark Kent', 'role' => 'Tenant', 'content' => 'Found a great apartment close to my workplace within my budget. Thank you!'],
    ];
    foreach($testis as $idx => $t) {
        Testimonial::firstOrCreate(
            ['client_name' => $t['name']],
            [
                'client_role' => $t['role'],
                'testimonial' => $t['content'],
                'rating' => 5,
                'status' => 'Active',
                'featured' => 1,
                'display_order' => $idx
            ]
        );
    }
    echo "Created 4 Testimonials.\n";

    DB::commit();
    echo "\nDATABASE POPULATION COMPLETE!\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
