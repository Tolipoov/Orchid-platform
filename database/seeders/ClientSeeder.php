<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ru_RU');
        
        // Assuming your JSON file structure is like this
        $phones = json_decode(file_get_contents(__DIR__ . '/files/phone.json'));
        
        foreach ($phones as $phone) {
            // Generate a random phone number using Faker
            $randomPhoneNumber = $faker->phoneNumber;
            
            // Normalize the phone number (for example, remove '+')
            $normalize = str_replace('+', '', $randomPhoneNumber);
            
            // Create a new Client record with the normalized phone number
            Client::create([
                'phone' => $normalize,
                // Add other fields as needed, using Faker for random data
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'birthday' => $faker->date('Y-m-d', '-20 years'),
                'service_id' => $faker->numberBetween(1, 10), // Assuming service_id range from 1 to 10
                'states' => 'interviewed', // Assuming a static state
            ]);
        }
    }
}