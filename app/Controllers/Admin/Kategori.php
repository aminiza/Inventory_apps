<?php 
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Kategori',
            'kategori' => (new KategoriModel())->findAll()
        ];

        return view('admin/kategori/index', $data);
    }

    public function store()
    {
        (new KategoriModel())->save($this->request->getPost());
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update($id) 
    {
        (new KategoriModel())->update($id, $this->request->getPost());
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        (new KategoriModel())->delete($id);
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
