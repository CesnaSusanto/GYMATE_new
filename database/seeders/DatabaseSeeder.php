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
        $personalTrainerId = DB::table('personal_trainer')->insertGetId([ // <--- Sesuaikan
            'user_id' => $userPTId,
            'nama_personal_trainer' => 'Budi Otot',
            'jenis_kelamin' => 'Laki-laki',
            'no_telp' => '081234567890',
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
