<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\KategoriModel;

class Home extends BaseController
{
    protected $barangModel;
    protected $transaksiModel;
    protected $kategoriModel;

    public function __construct()
    {
        // $this->checkAdmin();
        $this->barangModel = new BarangModel();
        $this->transaksiModel = new TransaksiModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index(): string
    {
        $jumlahBarang = $this->barangModel->countAll();
        $jumlahTransaksi = $this->transaksiModel->countAll();
        $jumlahKategori = $this->kategoriModel->countAll();

        // for chart
        $barang = $this->barangModel->getBarangWithKategori();
        $kategoriList = $this->kategoriModel->findAll();

        $stokPerKategori = [];
        foreach ($kategoriList as $k) {
            $total = 0;
            foreach ($barang as $b) {
                if ($b['id_kategori'] == $k['id_kategori']) {
                    $total += $b['stok'];
                }
            }

            $stokPerKategori[] = [
                'nama' => $k['nama_kategori'],
                'total' => $total
            ];
        }

        $stokRendah = array_filter($barang, fn($b) => $b['stok'] <= 5);

        $data = [
            'title' => 'Dashboard',
            'jumlah_barang' => $jumlahBarang,
            'jumlah_kategori' => $jumlahKategori,
            'jumlah_transaksi' => $jumlahTransaksi,
            'stokPerKategori' => $stokPerKategori,
            'stokRendah' => $stokRendah
        ];

        return view('home/dashboard', $data);
    }
}
