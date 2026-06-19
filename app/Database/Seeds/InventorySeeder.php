<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class InventorySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');

        // 1. Seed Users
        $users = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Administrator Utama',
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'petugas1',
                'password' => password_hash('petugas123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Petugas Gudang',
                'role' => 'petugas',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. Seed Kategori
        $kategoriData = [
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Perangkat elektronik dan aksesorisnya'],
            ['nama_kategori' => 'Alat Tulis', 'deskripsi' => 'Peralatan kantor dan sekolah'],
            ['nama_kategori' => 'Bahan Makanan', 'deskripsi' => 'Bahan baku atau makanan kemasan'],
        ];
        $this->db->table('kategori')->insertBatch($kategoriData);

        // Ambil ID kategori
        $kategori = $this->db->table('kategori')->get()->getResultArray();
        $kategoriIds = array_column($kategori, 'id_kategori');

        // 3. Seed Barang
        $barang = [];
        $kode = 1;
        $satuanList = ['Pcs', 'Box', 'Kg', 'Lusin', 'Pack'];
        foreach ($kategoriIds as $id_kategori) {
            for ($i = 0; $i < 3; $i++) {
                $barang[] = [
                    'kode_barang' => 'BRG-' . str_pad($kode++, 3, '0', STR_PAD_LEFT),
                    'nama_barang' => $faker->words(3, true),
                    'id_kategori' => $id_kategori,
                    'stok' => rand(10, 200),
                    'satuan' => $satuanList[array_rand($satuanList)],
                    'harga_beli' => rand(5000, 1000000),
                    'harga_jual' => rand(6000, 1200000),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        $this->db->table('barang')->insertBatch($barang);

        // 4. Seed Transaksi Stok (opsional, contoh data)
        $barangList = $this->db->table('barang')->get()->getResultArray();
        $transaksi = [];
        foreach ($barangList as $b) {
            // Stok masuk
            $transaksi[] = [
                'id_barang' => $b['id_barang'],
                'tipe_transaksi' => 'masuk',
                'jumlah' => $b['stok'],
                'keterangan' => 'Stok awal sistem',
                'tanggal_transaksi' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->table('transaksi_stok')->insertBatch($transaksi);
    }
}