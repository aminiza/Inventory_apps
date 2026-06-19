<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\KategoriModel;

class Barang extends BaseController
{
    public function index()
    {
        $barangModel = new BarangModel();

        // mengambil query pencarian
        $search = $this->request->getGet('search');
        $perPage = 5;
        $currentPage = $this->request->getGet('page_barang') ?? 1;

        // membangun kuery dengan join dan pencarian
        $query = $barangModel->select('barang.*, kategori.nama_kategori')->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left');

        if(!empty($search)) {
            $query->groupStart()->like('barang.kode_barang', $search)->orLike('barang.nama_barang', $search)->orLike('kategori.nama_kategori', $search)->groupEnd();
        }

        // menghitung total data
        $total = (clone $query)->countAllResults(false);

        // mengambil data halaman saat ini
        $barang = $query->orderBy('barang.id_barang', 'DESC')->paginate($perPage, 'barang', $currentPage);

        // $pager = \Config\Services::pager();
        // $barang = $barangModel->paginate(10, 'barang');
        
        $data = [
            'title' => 'Kelola Barang',
            'barang' => $barang,
            'search' => $search,
            'total' => $total,
            'showAction' => true
            // 'pager' => $pager,
        ];

        return view('admin/barang/index', $data);
    }

    public function create()
    {
        $kategori = (new KategoriModel())->findAll();

        $data = [
            'title' => 'Tambah Barang',
            'kategori' => $kategori
        ];

        return view('admin/barang/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto_barang');
        $namaFoto = null;
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/barang', $namaFoto);
        }

        (new BarangModel())->save([
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'stok' => $this->request->getPost('stok'),
            'satuan' => $this->request->getPost('satuan'),
            'harga_beli' => $this->request->getPost('harga_beli'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'foto_barang' => $namaFoto
        ]);

        return redirect()->to('/admin/barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = (new BarangModel())->find($id);
        $kategori = (new KategoriModel())->findAll();

        $data = [
            'title' => 'Edit Barang',
            'barang' => $barang,
            'kategori' => $kategori
        ];

        return view('admin/barang/edit', $data);
    }

    public function update($id)
    {
        $model = new BarangModel();
        $barangLama = $model->find($id);

        $foto = $this->request->getFile('foto_barang');
        $namaFoto = $barangLama['foto_barang'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($namaFoto && file_exists(FCPATH . 'uploads/barang/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/barang/' . $namaFoto);
            }

            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/barang', $namaFoto);
        }

        $model->update($id, [
            'kode_barang' => $this->request->getPost('kode_barang'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'stok' => $this->request->getPost('stok'),
            'satuan' => $this->request->getPost('satuan'),
            'harga_beli' => $this->request->getPost('harga_beli'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'foto_barang' => $namaFoto
        ]);

        return redirect()->to('/admin/barang')->with('success', 'Barang berhasil diperbarui.');
    }

    public function detail($id)
    {
        $model = new BarangModel();
        $barang = $model->findWithKategori($id);

        $data = [
            'title' => 'Detail Barang',
            'barang' => $barang
        ];

        return view('admin/barang/detail', $data);
    }

    public function delete($id)
    {
        $model = new BarangModel();
        $barang = $model->find($id);
        if ($barang['foto_barang'] && file_exists(FCPATH . 'uploads/barang/' . $barang['foto_barang'])) {
            unlink(FCPATH . 'uploads/barang' . $barang['foto_barang']);
        }
        $model->delete($id);
        return redirect()->to('/admin/barang')->with('success', 'Barang berhasil dihapus');
    }
}
