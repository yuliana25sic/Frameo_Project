<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin & Customer Uji Coba
        User::create([
            'name' => 'Admin FRAMEO',
            'email' => 'admin@frameo.com',
            'phone_number' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Yuliana Customer',
            'email' => 'customer@frameo.com',
            'phone_number' => '089876543210',
            'role' => 'customer',
            'password' => Hash::make('password123'),
        ]);

        // 2. Data Cabang Studio
        Branch::create([
            'name' => 'FRAMEO Studio - Sudirman',
            'address' => 'Jl. Jend. Sudirman No. 120, Pekanbaru',
            'city' => 'Pekanbaru',
            'phone' => '0761-555123',
            'open_time' => '09:00:00',
            'close_time' => '21:00:00',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'FRAMEO Studio - Panam',
            'address' => 'Jl. HR. Soebrantas KM. 12, Panam, Pekanbaru',
            'city' => 'Pekanbaru',
            'phone' => '0761-555456',
            'open_time' => '10:00:00',
            'close_time' => '22:00:00',
            'is_active' => true,
        ]);

        // 3. Kategori Paket Foto
        $catBasic = Category::create([
            'name' => 'Basic Self Photo',
            'slug' => 'basic-self-photo',
            'description' => 'Sesi foto mandiri dengan latar polos minimalis dan pencahayaan studio profesional.',
        ]);

        $catSpotlight = Category::create([
            'name' => 'Spotlight & Aesthetic',
            'slug' => 'spotlight-aesthetic',
            'description' => 'Sesi foto dengan efek pencahayaan dramatis, proyektor, atau tema estetik khusus.',
        ]);

        $catGroup = Category::create([
            'name' => 'Group & Graduation',
            'slug' => 'group-graduation',
            'description' => 'Ruang studio lebih luas untuk foto bersama sahabat, keluarga, atau momen wisuda.',
        ]);

        // 4. Daftar Paket Foto
        Package::create([
            'category_id' => $catBasic->id,
            'name' => 'Mono Solo / Duo (15 Menit)',
            'description' => '15 menit sesi foto sepuasnya + 10 menit pilih foto. Free 2 cetak foto ukuran 4R + semua softfile via Google Drive.',
            'duration_minutes' => 15,
            'max_people' => 2,
            'price' => 65000,
            'is_active' => true,
        ]);

        Package::create([
            'category_id' => $catSpotlight->id,
            'name' => 'Spotlight Glow Session (20 Menit)',
            'description' => '20 menit sesi foto dengan lampu sorot artistik + 10 menit pilih foto. Free 3 cetak foto 4R + semua softfile.',
            'duration_minutes' => 20,
            'max_people' => 3,
            'price' => 95000,
            'is_active' => true,
        ]);

        Package::create([
            'category_id' => $catGroup->id,
            'name' => 'Squad & Family Frame (30 Menit)',
            'description' => '30 menit sesi foto untuk maksimal 8 orang + 15 menit pilih foto. Free 5 cetak foto 4R + 1 cetak ukuran 10R + semua softfile.',
            'duration_minutes' => 30,
            'max_people' => 8,
            'price' => 160000,
            'is_active' => true,
        ]);

        // 5. Daftar Add-on (Layanan Tambahan)
        Addon::create([
            'name' => 'Extra Person (Per Orang)',
            'description' => 'Tambahan peserta di luar kapasitas maksimal paket.',
            'price' => 20000,
            'is_active' => true,
        ]);

        Addon::create([
            'name' => 'Extra Print 4R (2 Lembar)',
            'description' => 'Tambahan cetak foto kualitas lab ukuran 4R beserta frame kertas.',
            'price' => 15000,
            'is_active' => true,
        ]);

        Addon::create([
            'name' => 'Extra Time (+10 Menit)',
            'description' => 'Perpanjangan waktu sesi pemotretan di dalam studio.',
            'price' => 35000,
            'is_active' => true,
        ]);
    }
}
