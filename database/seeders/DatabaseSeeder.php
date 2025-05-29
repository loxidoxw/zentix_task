<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Phone;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $contacts=Contact::factory()->count(20)->create();

       $contacts->each(function ($contact) {
           Phone::factory()->count(random_int(1,3))->create(['contact_id'=>$contact->id]);
       });
    }
}
