<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    public function run()
    {
        DB::table('properties')->insert([
            [
                'name' => 'Luxury Villa in Paris',
                'address' => '123 Rue de la Paix',
                'city' => 'Paris',
                'state' => 'Île-de-France',
                'zip_code' => '75001',
                'country' => 'France',
                'price' => 5000000,
                'type' => 'Villa',
                'size' => 3500,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'features' => 'Swimming pool, garden',
                'status' => 'For Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modern Apartment in Tokyo',
                'address' => '1-1-1 Shibuya',
                'city' => 'Tokyo',
                'state' => 'Tokyo',
                'zip_code' => '150-0002',
                'country' => 'Japan',
                'price' => 1200000,
                'type' => 'Apartment',
                'size' => 800,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'features' => 'City view, modern kitchen',
                'status' => 'For Rent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beachfront Condo in Sydney',
                'address' => '10 Bondi Beach Road',
                'city' => 'Sydney',
                'state' => 'New South Wales',
                'zip_code' => '2026',
                'country' => 'Australia',
                'price' => 2500000,
                'type' => 'Condo',
                'size' => 1200,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'features' => 'Beach view, gym',
                'status' => 'For Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Penthouse in Dubai Marina',
                'address' => 'Dubai Marina Towers',
                'city' => 'Dubai',
                'state' => 'Dubai',
                'zip_code' => '00000',
                'country' => 'UAE',
                'price' => 9000000,
                'type' => 'Penthouse',
                'size' => 4000,
                'bedrooms' => 4,
                'bathrooms' => 5,
                'features' => 'Private elevator, rooftop terrace',
                'status' => 'Sold',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Country House in Tuscany',
                'address' => 'Via San Giovanni, 45',
                'city' => 'Florence',
                'state' => 'Tuscany',
                'zip_code' => '50100',
                'country' => 'Italy',
                'price' => 3500000,
                'type' => 'House',
                'size' => 2500,
                'bedrooms' => 6,
                'bathrooms' => 4,
                'features' => 'Vineyard, pool',
                'status' => 'For Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Loft in Central London',
                'address' => '20 Oxford Street',
                'city' => 'London',
                'state' => 'England',
                'zip_code' => 'W1D 1AS',
                'country' => 'United Kingdom',
                'price' => 3500000,
                'type' => 'Loft',
                'size' => 1500,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'features' => 'High ceilings, close to public transport',
                'status' => 'For Rent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Château in Bordeaux',
                'address' => 'Château de Montagne, Route de Bordeaux',
                'city' => 'Bordeaux',
                'state' => 'Aquitaine',
                'zip_code' => '33000',
                'country' => 'France',
                'price' => 8000000,
                'type' => 'Château',
                'size' => 5000,
                'bedrooms' => 8,
                'bathrooms' => 7,
                'features' => 'Wine cellar, private park',
                'status' => 'For Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Villa in Cape Town',
                'address' => '12 Victoria Road',
                'city' => 'Cape Town',
                'state' => 'Western Cape',
                'zip_code' => '8005',
                'country' => 'South Africa',
                'price' => 2000000,
                'type' => 'Villa',
                'size' => 3000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'features' => 'Sea view, garden',
                'status' => 'For Rent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apartment in New Delhi',
                'address' => '56 Connaught Place',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'zip_code' => '110001',
                'country' => 'India',
                'price' => 1500000,
                'type' => 'Apartment',
                'size' => 1000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'features' => 'Close to shopping, parking space',
                'status' => 'For Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mountain Retreat in Zurich',
                'address' => '12 Höhenstrasse',
                'city' => 'Zurich',
                'state' => 'Zurich',
                'zip_code' => '8000',
                'country' => 'Switzerland',
                'price' => 4500000,
                'type' => 'Retreat',
                'size' => 2800,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'features' => 'Mountain view, sauna',
                'status' => 'For Rent',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
