<?php

namespace Database\Seeders;

use App\Models\RefundStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefundStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        RefundStatus::insert([
            ["name" => "Pendente"],
            ["name" => "Negado"],
            ["name" => "Estornado"],
            ["name" => "Cancelado"],
        ]);

    }
}
