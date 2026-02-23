<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
    $userCSId = DB::table('users')->insertGetId([
            'username' => 'cs',
            'password' => Hash::make('password123'),
            'role' => 'customer_service',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userPelangganId = DB::table('users')->insertGetId([
            'username' => 'pelanggan',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userPTId = DB::table('users')->insertGetId([
            'username' => 'pt',
            'password' => Hash::make('password123'),
            'role' => 'personal_trainer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userPelanggan2Id = DB::table('users')->insertGetId([
            'username' => 'premium',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // --- 2. Seed Customer Services ---
        DB::table('customer_service')->insert([ // <--- Sesuaikan
            'user_id' => $userCSId,
            'nama_cs' => 'Dewi Layanan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $customerServiceId = DB::table('customer_service')->value('id_cs'); // <--- Sesuaikan


        // --- 3. Seed Personal Trainers ---
        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Agus Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Bambang Pamungkas',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Citra Lestari',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Dedi Wijaya',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Eka Putri',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Fajar Nugraha',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Gita Kirana',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Hendra Setiawan',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Intan Permata',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Joko Anwar',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Kevin Sanjaya',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Lesti Anggraini',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Muhammad Fatih',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Nadia Saphira',
            'jenis_kelamin' => 'Perempuan',
            'no_telp' => '081234567014',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ 
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Oka Antara',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // --- 4. Seed Pelanggans ---
           $pelanggan1Id = DB::table('pelanggan')->insertGetId([
               'user_id' => $userPelangganId,
               'id_personal_trainer' => $personalTrainerId,
               'nama_pelanggan' => 'Andi Santoso',
               'jenis_kelamin' => 'Laki-laki',
               'no_telp' => '087654321098',
               'tanggal_bergabung' => '2023-01-15',
               // UBAH BARIS INI:
               'paket_layanan' => 'biasa', // Sebelumnya mungkin 'Premium' atau 'Ultimate'
               'berat_badan' => 75,
               'tinggi_badan' => 170,
               'status' => 'Aktif',
               'created_at' => now(),
               'updated_at' => now(),
           ]);

           $pelanggan2Id = DB::table('pelanggan')->insertGetId([
               'user_id' => $userPelanggan2Id,
               'id_personal_trainer' => $personalTrainerId,
               'nama_pelanggan' => 'Siti Nurjannah',
               'jenis_kelamin' => 'Perempuan',
               'no_telp' => '081122334455',
               'tanggal_bergabung' => '2024-03-10',
               // UBAH BARIS INI:
               'paket_layanan' => 'premium', // Sebelumnya mungkin 'Basic'
               'berat_badan' => 58,
               'tinggi_badan' => 162,
               'status' => 'Aktif',
               'created_at' => now(),
               'updated_at' => now(),
           ]);

        // --- 5. Seed Catatans ---
        DB::table('catatan')->insert([ // <--- Sesuaikan
            'id_pelanggan' => $pelanggan1Id,
            'tanggal_latihan' => '2024-07-10',
            'kegiatan_latihan' => 'Latihan beban dada dan tricep',
            'catatan_latihan' => 'Fokus pada form, angkat 80% dari 1RM.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('catatan')->insert([ // <--- Sesuaikan
            'id_pelanggan' => $pelanggan2Id,
            'tanggal_latihan' => '2024-07-12',
            'kegiatan_latihan' => 'Yoga dan kardio ringan',
            'catatan_latihan' => 'Peningkatan fleksibilitas, detak jantung stabil.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // --- 6. Seed Kartus ---
        DB::table('kartu')->insert([ // <--- Sesuaikan
            'id_pelanggan' => $pelanggan1Id,
            'id_personal_trainer' => $personalTrainerId,
            'tanggal_latihan' => '2024-07-10',
            'kegiatan_latihan' => 'Kartu kehadiran latihan pagi',
            'catatan_latihan' => 'Hadir tepat waktu, semangat tinggi.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('kartu')->insert([ // <--- Sesuaikan
            'id_pelanggan' => $pelanggan2Id,
            'id_personal_trainer' => $personalTrainerId,
            'tanggal_latihan' => '2024-07-12',
            'kegiatan_latihan' => 'Kartu kehadiran sesi yoga',
            'catatan_latihan' => 'Partisipasi aktif dalam sesi.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $this->command->info('Static database seeding completed successfully with singular table names!');
    }
}
