<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-6">Tambah Transaksi Stok</h1>

<form action="<?= base_url('/petugas/stok/store') ?>" method="post">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 mb-1">Barang</label>
            <select name="id_barang" class="w-full px-3 py-2 border rounded">
                <option value="">-- Pilih Barang --</option>
                <?php foreach ($barang as $b) : ?>
                    <option value="<?= $b['id_barang'] ?>"><?= esc($b['kode_barang']) ?> - <?= esc($b['nama_barang']) ?> (Stok: <?= $b['stok'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Tipe Transaksi</label>
            <select name="tipe_transaksi" class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih --</option>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Jumlah</label>
            <input type="number" name="jumlah" min="1" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Tanggal Transaksi</label>
            <input type="date" name="tanggal_transaksi" class="w-full px-3 py-2 border rounded" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Keterangan</label>
            <textarea name="keterangan" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
        </div>
    </div>

    <div class="mt-6 flex space-x-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Transaksi</button>
        <a href="<?= base_url('/petugas/stok') ?>" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
    </div>
</form>

<?= $this->endSection() ?>