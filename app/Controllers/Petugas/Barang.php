<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController; // Pastikan BaseController benar
use App\Models\BarangModel;

class Barang extends BaseController
{
    public function index()
    {
        $barangModel = new BarangModel();
        $search = $this->request->getGet('search'); 
        $perPage = 5;
        $currentPage = $this->request->getGet('page_barang') ?? 1;

        // Bangun query dasar
        $query = $barangModel
            ->select('barang.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left');

        // ✅ PERBAIKAN 1: Cek $search, bukan $query
        if (!empty($search)) {
            $query->groupStart()
                ->like('barang.kode_barang', $search)
                ->orLike('barang.nama_barang', $search)
                ->orLike('kategori.nama_kategori', $search)
                ->groupEnd();
        }

        $total = (clone $query)->countAllResults(false);
        $barang = $query->orderBy('barang.id_barang', 'DESC')->paginate($perPage, 'barang', $currentPage);

        $data = [
            'title' => 'Daftar Barang',
            'barang' => $barang,
            'search' => $search,
            'total' => $total,
            'showActions' => false
        ];

        return view('partials/barang_table', $data);
    }
}