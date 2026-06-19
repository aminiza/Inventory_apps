<?php 
namespace APP\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'id_kategori', 'stok', 'satuan', 'harga_beli', 'harga_jual', 'foto_barang'];
    protected $useTimestamps = true;

    public function getBarangWithKategori()
    {
        return $this->select('barang.*, kategori.nama_kategori')->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left')->findAll();
    }

    public function findWithKategori($id) {
        return $this->select('barang.*, kategori.nama_kategori')->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left')->where('id_barang', $id)->first();
    }
}
