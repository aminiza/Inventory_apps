<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-center items-start min-h-[70vh] p-4">
    <div class="w-full mx-w-3xl bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2"><?= esc($barang['nama_barang']) ?></h1>
            <p class="text-gray-600 mb-6">Kode: <span class="font-mono"><?= esc($barang['kode_barang']) ?></span></p>

            <!-- foto barang -->
            <div class="flex justify-center mb-6">
                <?php if ($barang['foto_barang'] && file_exists(FCPATH . 'uploads/barang/' . $barang['foto_barang'])) : ?>
                    <img src="<?= base_url('uploads/barang/' . $barang['foto_barang']) ?>" alt="<?= esc($barang['nama_barang']) ?>" class="rounded-lg border shadow object-cover w-full h-64 md:h-80">
                <?php else: ?>
                    <div class="flex items-center justify-center bg-gray-100 border-2 border-dashed rounded-lg w-full h-64 md:h-80"><span class="text-gray-500">Tidak ada foto</span></div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p><span class="font-semibold">Kategori:</span><?= esc($barang['nama_kategori']) ?? '-' ?></p>
                    <p><span class="font-semibold">Satuan:</span><?= esc($barang['satuan']) ?? '-' ?></p>
                    <p><span class="font-semibold">Stok:</span>
                        <span class="<?= $barang['stok'] > 5 ? 'text-gray-800' : 'text-red-500 font-bold' ?>">
                            <?= esc($barang['stok']) ?> <?= $barang['satuan'] ?>
                        </span>
                    </p>
                </div>
                <div>
                    <p><span class="font-semibold">Harga Beli:</span> Rp <?= number_format($barang['harga_beli'] ?? 0, 0, ',', '.') ?></p>
                    <p><span class="font-semibold">Harga Jual:</span> Rp <?= number_format($barang['harga_jual'] ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="javascript:history.back()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">⬅️ Kembali</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>