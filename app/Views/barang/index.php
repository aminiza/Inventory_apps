<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-4">Daftar Barang</h1>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Jual</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($barang as $b) :?>
            <tr>
                <td class="px-4 py-3"><?= esc($b['kode_barang']) ?></td>
                <td class="px-4 py-3"><?= esc($b['nama_barang']) ?></td>
                <td class="px-4 py-3"><?= esc($b['nama_kategori']) ?? '-' ?></td>
                <td class="px-4 py-3 <?= $b['stok'] < 5 ? 'text-red-600 font-bold' : '' ?>"><?= esc($b['stok']) ?> <?= esc($b['satuan']) ?></td>
                <td class="px-4 py-3">Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>