<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-gray-800">Selamat datang di InventoryApp</h1>
    <p class="mt-2 text-gray-600">Anda login sebagai <strong><?= esc(session()->get('role') === 'admin' ? 'Admin' : 'Petugas') ?></strong></p>

    <?php if (session()->get('role') === 'admin'): ?>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded">
                <h3 class="font-semibold">Barang</h3>
                <p class="text-2xl font-bold mt-1"><?= $jumlah_barang ?></p>
            </div>
            <div class="bg-green-50 p-4 rounded">
                <h3 class="font-semibold">Kategori</h3>
                <p class="text-2xl font-bold mt-1"><?= $jumlah_kategori ?></p>
            </div>
            <div class="bg-purple-50 p-4 rounded">
                <h3 class="font-semibold">Transaksi</h3>
                <p class="text-2xl font-bold mt-1"><?= $jumlah_transaksi ?></p>
            </div>
        </div>

    <?php else: ?>
        <div class="mt-6">
            <p class="text-gray-700">Anda dapat mengelola transaksi stok melalui menu <strong>Transasksi Stok</strong>.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Chart per kategori -->
<?php if (session()->get('role') == 'admin'): ?>
    <div class="mt-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Stok Barang per Kategori</h2>
        <div class="h-64">
            <canvas id="stokChart"></canvas>
        </div>
    </div>

    <!-- barang stok rendah -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4 text-red-600">Barang Stok Rendah (≤5)</h2>
        <?php if (empty($stokRendah)) : ?>
            <p class="text-gray-500">Tidak ada barang dengan stok rendah.</p>
        <?php else : ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Kode</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Kategori</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($stokRendah as $b) : ?>
                            <tr>
                                <td class="px-4 py-2"><?= esc($b['kode_barang']) ?></td>
                                <td class="px-4 py-2"><?= esc($b['nama_barang']) ?></td>
                                <td class="px-4 py-2"><?= esc($b['nama_kategori'] ?? '-') ?></td>
                                <td class="px-4 py-2 font-bold text-red-600"><?= $b['stok'] ?><?= esc($b['satuan']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Chart cdn -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stokChart').getContext('2d');
        const labels = <?= json_encode(array_column($stokPerKategori ?? [], 'nama')) ?>;
        const data = <?= json_encode(array_column($stokPerKategori ?? [], 'total')) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Stok',
                    data: data,
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
                    ],
                    borderColor: [
                        '#2563eb', '#0563eb', '#d97706', '#dc2626', '#7c3aed'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>