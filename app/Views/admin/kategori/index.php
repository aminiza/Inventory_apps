<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kelola Kategori</h1>
</div>

<!-- Form Tambah -->
<form action="<?= base_url('/admin/kategori/store') ?>" method="post" class="bg-white p-4 rounded shadow mb-6">
    <div class="flex gap-3">
        <input type="text" name="nama_kategori" placeholder="Nama kategori" class="flex-1 px-3 py-2 border rounded" required>
        <textarea name="deskripsi" placeholder="Deskripsi (opsional)" class="flex-1 px-3 py-2 border rounded"></textarea>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">+ Tambah</button>
    </div>
</form>

<!-- Daftar Kategori -->
<div class="bg-white rounded shadow">
    <table class="min-w-full divide-y">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Deskripsi</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kategori as $k): ?>
            <tr>
                <td class="px-4 py-3"><?= esc($k['nama_kategori']) ?></td>
                <td class="px-4 py-3"><?= esc($k['deskripsi'] ?? '—') ?></td>
                <td class="px-4 py-3 flex flex-col md:flex-row items-center">
                    <form action="<?= base_url("/admin/kategori/update/{$k['id_kategori']}") ?>" method="post" class="inline">
                    <div class="w-full flex items-center gap-2">
                        <input type="text" name="nama_kategori" value="<?= esc($k['nama_kategori']) ?>" class="w-35 px-2 py-1 border rounded text-sm">
                        <textarea name="deskripsi" class="w-35 px-2 py-1 border rounded text-sm"><?= esc($k['deskripsi'] ?? '') ?></textarea>
                        <button type="submit" class="ml-1 text-blue-500 text-sm">Simpan</button>
                    </div>
                    </form>
                    <a href="<?= base_url("/admin/kategori/delete/{$k['id_kategori']}") ?>" class="text-red-500 ml-2 text-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>