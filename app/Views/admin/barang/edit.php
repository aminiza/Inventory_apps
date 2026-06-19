<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-6">Tambah Barang</h1>

<form action="<?= base_url("/admin/barang/update/{$barang['id_barang']}") ?>" method="post" enctype="multipart/form-data">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 mb-1">Kode Barang</label>
            <input type="text" name="kode_barang" value="<?= esc($barang['kode_barang']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Nama Barang</label>
            <input type="text" name="nama_barang" value="<?= esc($barang['nama_barang']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Kategori</label>
            <select name="id_kategori" class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih --</option>
                <?php foreach ($kategori as $k) : ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= $k['id_kategori'] == $barang['id_kategori'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Satuan</label>
            <input type="text" name="satuan" placeholder="Pcs, Box, Kg, dll" value="<?= esc($barang['satuan']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Stok Awal</label>
            <input type="number" name="stok" value="<?= esc($barang['stok']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Harga Beli (Rp)</label>
            <input type="number" name="harga_beli" value="<?= esc($barang['harga_beli']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Harga Jual (Rp)</label>
            <input type="number" name="harga_jual" value="<?= esc($barang['harga_jual']) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Foto saat ini</label>
            <?php if ($barang['foto_barang']) : ?>
                <img src="<?= base_url('uploads/barang/' . $barang['foto_barang']) ?>" class="w-20 h-20 object-cover rounded mt-2">
            <?php else: ?>
                <p class="text-gray-500">Tidak ada foto</p>
            <?php endif; ?>
            <label class="block text-gray-700 mb-1">Foto (Opsional)</label>
            <input type="file" name="foto_barang" class="w-full" accept="image/*">
        </div>
    </div>

    <div class="mt-6 flex space-x-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui Barang</button>
        <a href="<?= base_url('/barang') ?>" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>