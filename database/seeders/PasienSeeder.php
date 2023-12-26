<?php

namespace Database\Seeders;

use App\Http\Controllers\Admin\LokasiController;
use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create();        

        $lokasi_desa = LokasiController::getAllLocationMappedId();

        for($a = 0; $a < 100; $a++) {
            
            $pasienModel = new Pasien();
            $pasienModel->nama = $faker->name();
            $pasienModel->jenis_kelamin = $faker->randomElement(['Pria', 'Wanita']);
            $pasienModel->umur = $faker->numberBetween(20, 75);
            $pasienModel->umur = $faker->numberBetween(20, 75);
            $pasienModel->lokasi_desa = $faker->randomKey($lokasi_desa);
            $pasienModel->tanggal_ditambahkan = $faker->dateTimeBetween('-4 months', 'this month');
            $pasienModel->save();
        }
                
    }
}
