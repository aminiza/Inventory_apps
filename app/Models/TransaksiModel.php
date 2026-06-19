<?php 
namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model 
{
    protected $table = 'transaksi_stok';
    protected $primaryKey = 'id_transaski';
    protected $allowedFields = ['id_barang', 'tipe_transaksi', 'jumlah', 'keterangan', 'tanggal_transaksi'];
    protected $useTimestamps = false;
}