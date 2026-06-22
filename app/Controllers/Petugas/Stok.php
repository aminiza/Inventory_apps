<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiModel;

class Stok extends BaseController
{

    public function index()
    {
        $transaksiModel = new TransaksiModel();

        // $transaksi = (new TransaksiModel())->select('transaksi_stok.*,barang.nama_barang')->join('barang', 'barang.id_barang = transaksi_stok.id_barang')->orderBy('created_at', 'DESC')->findAll();

        $search = $this->request->getGet('search');
        $perPage = 5;
        $currentPage = $this->request->getGet('page_stok') ?? 1;


        $query = $transaksiModel->select('transaksi_stok.*,barang.nama_barang, barang.kode_barang')->join('barang', 'barang.id_barang = transaksi_stok.id_barang', 'left');

        if (!empty($search)) {
            $query->groupStart()->like('transaksi_stok.tanggal_transaksi', $search)->orLike('barang.nama_barang', $search)->orLike('transaksi_stok.keterangan', $search)->groupEnd();
        }

        $total = (clone $query)->countAllResults(false);
        $transaksi = $query->orderBy('created_at', 'DESC')->paginate($perPage, 'stok', $currentPage);

        // dd([
        //     'total' => $total,
        //     'search' => $search,
        //     'transaksi' => $transaksi,
        // ]);

        $data = [
            'title' => 'Transaksi Stok',
            'total' => $total,
            'search' => $search,
            'transaksi' => $transaksi,
        ];

        return view('petugas/stok/index', $data);
    }

    public function create()
    {
        $barang = (new BarangModel())->findAll();
        $data = [
            'title' => 'Tambah Transaksi',
            'barang' => $barang
        ];

        return view('petugas/stok/create', $data);
    }

    public function store()
    {
        $id_barang = $this->request->getPost('id_barang');
        $tipe = $this->request->getPost('tipe_transaksi');
        $jumlah = $this->request->getPost('jumlah');

        $barang = (new BarangModel())->find($id_barang);
        if ($tipe === 'keluar' && $jumlah > $barang['stok']) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        (new TransaksiModel())->save([
            'id_barang' => $id_barang,
            'tipe_transaksi' => $tipe,
            'jumlah' => $jumlah,
            'keterangan' => $this->request->getPost('keterangan'),
            'tanggal_transaksi' => $this->request->getPost('tanggal_transaksi')
        ]);

        $newStok = $tipe === 'masuk' ? $barang['stok'] + $jumlah : $barang['stok'] - $jumlah;
        (new BarangModel())->update($id_barang, ['stok' => $newStok]);

        return redirect()->to('/petugas/stok')->with('success', 'Transaksi stok berhasil di catat.');
    }

    public function edit($id) 
    {
        $transaksi = (new TransaksiModel())->find($id);
        $barang = (new BarangModel())->findAll();
        $data = [
            'title' => 'Edit Transaksi',
            'transaksi' => $transaksi,
            'barang' => $barang
        ];

        return view('petugas/stok/edit', $data);
    }

    public function update($id)
    {
        (new TransaksiModel())->update($id, $this->request->getPost());
        return redirect()->to('/petugas/stok')->with('success', 'Transaksi stok berhasil diperbarui.');
    }

    public function delete($id)
    {
        (new TransaksiModel())->delete($id);
        return redirect()->to('/petugas/stok')->with('success', 'Transaksi stok berhasil dihapus.');
    }

    public function search()
    {
        $search = $this->request->getGet('search');
        $perPage = 5;
        $currentPage = $this->request->getGet('page_stok') ?? 1;

        $transaksiModel = new TransaksiModel();

        $query = $transaksiModel
            ->select('transaksi_stok.*, barang.nama_barang, barang.kode_barang')
            ->join('barang', 'barang.id_barang = transaksi_stok.id_barang', 'left');

        if (!empty($search)) {
            $query->groupStart()
                ->like('barang.kode_barang', $search)
                ->orLike('barang.nama_barang', $search)
                ->orLike('transaksi_stok.keterangan', $search)
                ->groupEnd();
        }

        $total = (clone $query)->countAllResults(false);
        $transaksi = $query
            ->orderBy('transaksi_stok.id_transaksi', 'DESC')
            ->paginate($perPage, 'stok', $currentPage);

        $data =  [
            'transaksi' => $transaksi,
            'total' => $total,
            'search' => $search
        ];

        return $this->response->setJSON([
            'html' => view('petugas/stok/_table', $data)
        ]);
    }
}
