<!-- Info Hasil -->
<div class="mb-4 text-sm text-gray-600">
    Menampilkan <?= count($transaksi) ?> dari <?= $total ?> transaksi
    <?php if (!empty($search)): ?>
        untuk pencarian: <strong><?= esc($search) ?></strong>
    <?php endif; ?>
</div>

<!-- Tabel Transaksi Stok -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font- medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($transaksi)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2">Tidak ada transaksi ditemukan.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transaksi as $t): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= esc($t['tanggal_transaksi']) ?></div>
                                <div class="text-sm text-gray-500"><?= esc($t['created_at']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?= esc($t['kode_barang']) ?></div>
                                <div class="text-sm text-gray-500"><?= esc($t['nama_barang']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?= $t['tipe_transaksi'] === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $t['tipe_transaksi'] === 'masuk' ? 'Masuk' : 'Keluar' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                <?= esc($t['jumlah']) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?= esc($t['keterangan'] ?? '—') ?>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a class="px-3 py-2 bg-red-100 rounded-sm text-red-600" href="/petugas/stok/delete/<?= $t['id_transaksi'] ?>" onclick="return confirm('Yakin ingin menghapus')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <a class="px-3 py-2 bg-indigo-100 rounded-sm text-indigo-600" href="/petugas/stok/edit/<?= $t['id_transaksi'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?= service('pager')->only(['search'])->links('stok', 'tailwind_pagination') ?>
</div>