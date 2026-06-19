<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTables extends Migration
{
    public function up()
    {
        // Tabel users
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'petugas'],
                'default' => 'admin',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');

        // Tabel kategori
        $this->forge->addField([
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_kategori', true);
        $this->forge->createTable('kategori');

        // Tabel barang
        $this->forge->addField([
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'stok' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'harga_beli' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'harga_jual' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'foto_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_barang', true);
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'SET NULL', 'CASCADE');
        $this->forge->createTable('barang');

        // Tabel transaksi_stok
        $this->forge->addField([
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tipe_transaksi' => [
                'type' => 'ENUM',
                'constraint' => ['masuk', 'keluar'],
            ],
            'jumlah' => [
                'type' => 'INT',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_transaksi' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi_stok');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_stok', true);
        $this->forge->dropTable('barang', true);
        $this->forge->dropTable('kategori', true);
        $this->forge->dropTable('users', true);
    }
}