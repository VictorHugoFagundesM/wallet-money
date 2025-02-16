<?php

namespace Database\Seeders;

use App\Models\BankSlip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankSlip::factory(100)->create();
    }
}
