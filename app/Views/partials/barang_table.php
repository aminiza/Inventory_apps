<?php 
$showAction = $showAction ?? false;
$barang = $barang ?? [];
$total = $total ?? 0;
$search = $search ?? '';
$role = session()->get('role');

?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-bold"><?= $role === 'admin' ? 'Kelola Barang' : 'Daftar Barang' ?></h1>
    <a href="<?= base_url('/admin/barang/create') ?>" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 whitespace-nowrap">+ Tambah Barang</a>
</div>

<!-- Form pencarian -->
<form method="get" class="mb-6">
    <div class="flex gap-2">
        <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari kode, nama barang, atau kategori..." class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <div class="w-65 flex items-center gap-3">
            <button type="submit" class="flex items-center px-4 py-2 rounded-md text-sm border border-gray-300 text-gray-600 hover:bg-gray-500 hover:text-white gap-1 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                Cari</button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('/admin/barang') ?>" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Reset</a>
            <?php endif; ?>
        </div>
    </div>
</form>

<?php if (!empty($search)): ?>
    <div class="mb-4 text-sm text-gray-600">
        Menampilkan <?= count($barang) ?> dari <?= $total ?> barang untuk pencarian : <strong><?= esc($search) ?></strong>
    </div>
<?php else: ?>
    <div class="mb-4 text-sm text-gray-400">
        Menampilkan <?= count($barang) ?> dari <?= $total ?> barang
    </div>
<?php endif; ?>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">Foto</th>
                <th class="px-4 py-3 text-left">Kode</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Stok</th>
                <th class="px-4 py-3 text-left">Harga Jual</th>
                <?php if ($showAction) : ?>
                <th class="px-4 py-3 text-left">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($barang)): ?>
                <tr>
                    <td colspan="<?= $showAction ? 7 : 6  ?>" class="px-4 py-3 text-center text-gray-500">Tidak ada barang ditemukan</td>
                </tr>
            <?php else: ?>
                <?php foreach ($barang as $b): ?>
                    <tr>
                        <td class="px-4 py-3">
                            <?php if ($b['foto_barang']): ?>
                                <a href="<?= base_url("admin/barang/detail/{$b['id_barang']}") ?>">
                                    <img src="<?= base_url('uploads/barang/' . $b['foto_barang']) ?>" class="w-10 h-10 object-cover rounded">
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url("admin/barang/detail/{$b['id_barang']}") ?>" class="text-blue-600 hover:underline text-sm">
                                    Lihat Detail
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3"><?= esc($b['kode_barang']) ?></td>
                        <td class="px-4 py-3"><?= esc($b['nama_barang']) ?></td>
                        <td class="px-4 py-3"><?= esc($b['nama_kategori'] ?? '—') ?></td>
                        <td class="px-4 py-3 <?= $b['stok'] < 5 ? 'text-red-600 font-bold' : '' ?>"><?= $b['stok'] ?> <?= esc($b['satuan']) ?></td>
                        <td class="px-4 py-3">Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
                        <?php if($showAction): ?>
                        <td class="px-4 py-3 space-x-2">
                            <a href="<?= base_url("admin/barang/edit/{$b['id_barang']}") ?>" class="text-blue-500">Edit</a>
                            <a href="<?= base_url("admin/barang/delete/{$b['id_barang']}") ?>" class="text-red-500" onclick="return confirm('Hapus barang ini?')">Hapus</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- pagination -->
<div class="mt-6">
    <?= service('pager')->only(['search'])->links('barang', 'tailwind_pagination') ?>
</div>

<script>
    // document.querySelector('input[name="search"]').addEventListener('input', function() {
    //     clearTimeout(window.searchTimeout);
    //     window.searchTimeout = setTimeout(() => {
    //         document.querySelector('form').submit();
    //     }, 500);
    // });
</script>

<?= $this->endSection() ?>