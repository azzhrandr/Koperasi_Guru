<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Administrator Koperasi',
                'email' => 'admin@koperasi.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nip' => 'ADMIN-01',
                'address' => 'Kantor Tata Usaha Sekolah',
                'phone' => '081234567890',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Budi Setiawan, S.Pd.',
                'email' => 'guru@koperasi.id',
                'password' => Hash::make('guru123'),
                'role' => 'anggota',
                'nip' => '198503122010011002',
                'address' => 'Jl. Pendidikan No. 45, Bandung',
                'phone' => '089876543210',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Siti Aminah, M.Pd.',
                'email' => 'siti@koperasi.id',
                'password' => Hash::make('guru123'),
                'role' => 'anggota',
                'nip' => '198807242014022001',
                'address' => 'Jl. Merdeka No. 12, Bandung',
                'phone' => '081223344556',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'name' => 'Drs. Ahmad Subagja',
                'email' => 'ahmad@koperasi.id',
                'password' => Hash::make('guru123'),
                'role' => 'anggota',
                'nip' => '197211051998031003',
                'address' => 'Komp. Pendidik Blok C2, Bandung',
                'phone' => '085712345678',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'name' => 'Rina Wijaya, S.Si.',
                'email' => 'rina@koperasi.id',
                'password' => Hash::make('guru123'),
                'role' => 'anggota',
                'nip' => '199209152019032011',
                'address' => 'Jl. Cihampelas No. 102, Bandung',
                'phone' => '082198765432',
                'status' => 'nonaktif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 2. Seed Simpanan
        DB::table('simpanan')->insert([
            ['id' => 1, 'user_id' => 2, 'tipe_simpanan' => 'pokok', 'nominal' => 500000, 'tanggal_transaksi' => '2026-01-05', 'keterangan' => 'Simpanan Pokok Awal Keanggotaan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 2, 'tipe_simpanan' => 'wajib', 'nominal' => 100000, 'tanggal_transaksi' => '2026-02-05', 'keterangan' => 'Simpanan Wajib Februari 2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => 2, 'tipe_simpanan' => 'wajib', 'nominal' => 100000, 'tanggal_transaksi' => '2026-03-05', 'keterangan' => 'Simpanan Wajib Maret 2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'user_id' => 2, 'tipe_simpanan' => 'sukarela', 'nominal' => 250000, 'tanggal_transaksi' => '2026-03-10', 'keterangan' => 'Simpanan Sukarela Kegiatan Guru', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'user_id' => 3, 'tipe_simpanan' => 'pokok', 'nominal' => 500000, 'tanggal_transaksi' => '2026-02-15', 'keterangan' => 'Simpanan Pokok Awal Keanggotaan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'user_id' => 3, 'tipe_simpanan' => 'wajib', 'nominal' => 100000, 'tanggal_transaksi' => '2026-03-15', 'keterangan' => 'Simpanan Wajib Maret 2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'user_id' => 4, 'tipe_simpanan' => 'pokok', 'nominal' => 500000, 'tanggal_transaksi' => '2026-01-10', 'keterangan' => 'Simpanan Pokok Awal Keanggotaan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'user_id' => 4, 'tipe_simpanan' => 'wajib', 'nominal' => 100000, 'tanggal_transaksi' => '2026-02-10', 'keterangan' => 'Simpanan Wajib Februari 2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'user_id' => 4, 'tipe_simpanan' => 'wajib', 'nominal' => 100000, 'tanggal_transaksi' => '2026-03-10', 'keterangan' => 'Simpanan Wajib Maret 2026', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'user_id' => 4, 'tipe_simpanan' => 'sukarela', 'nominal' => 1500000, 'tanggal_transaksi' => '2026-03-25', 'keterangan' => 'Simpanan Sukarela THR', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // 3. Seed Pinjaman
        DB::table('pinjaman')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'nominal_pinjaman' => 5000000,
                'bunga_persen' => 1.5,
                'lama_angsuran_bulan' => 10,
                'sisa_angsuran_bulan' => 8,
                'tanggal_pengajuan' => '2026-02-01',
                'tanggal_jatuh_tempo' => '2026-12-01',
                'status' => 'berjalan',
                'alasan' => 'Biaya perbaikan atap rumah bocor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'nominal_pinjaman' => 3000000,
                'bunga_persen' => 1.5,
                'lama_angsuran_bulan' => 6,
                'sisa_angsuran_bulan' => 6,
                'tanggal_pengajuan' => '2026-06-20',
                'tanggal_jatuh_tempo' => null,
                'status' => 'menunggu',
                'alasan' => 'Biaya pendaftaran sekolah anak',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'nominal_pinjaman' => 10000000,
                'bunga_persen' => 1.2,
                'lama_angsuran_bulan' => 12,
                'sisa_angsuran_bulan' => 0,
                'tanggal_pengajuan' => '2025-05-10',
                'tanggal_jatuh_tempo' => '2026-05-10',
                'status' => 'lunas',
                'alasan' => 'Kebutuhan mendesak pengobatan keluarga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'nominal_pinjaman' => 2000000,
                'bunga_persen' => 0.0,
                'lama_angsuran_bulan' => 4,
                'sisa_angsuran_bulan' => 4,
                'tanggal_pengajuan' => '2026-05-12',
                'tanggal_jatuh_tempo' => null,
                'status' => 'ditolak',
                'alasan' => 'Pengajuan pinjaman ditolak karena sisa pinjaman sebelumnya masih aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 4. Seed Angsuran
        DB::table('angsuran')->insert([
            ['id' => 1, 'pinjaman_id' => 1, 'angsuran_ke' => 1, 'nominal_bayar' => 575000, 'tanggal_bayar' => '2026-03-01', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'pinjaman_id' => 1, 'angsuran_ke' => 2, 'nominal_bayar' => 575000, 'tanggal_bayar' => '2026-04-01', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
