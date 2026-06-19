<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Inventory App') ?> - InventoryApp</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#64748b'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">
    <!-- Navbar - Fixed Top -->
    <nav class="fixed top-0 left-0 right-0 z-40 bg-white shadow-md h-16">
        <div class="mx-auto px-4 h-full flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div id="toggle" class="w-8 h-8 flex items-center cursor-pointer md:hidden text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>
                <img id="image" class="w-8 h-8 hidden md:block" src="<?= base_url('img/inventory-manage.svg') ?>" alt="logo inventory">
                <h2 class="text-xl font-bold text-primary">InventoryApp</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Halo, <strong><?= esc(session()->get('nama_lengkap') ?? session()->get('username')) ?></strong></span>
                <a href="<?= base_url('/logout') ?>" class="text-red-500 hover:underline text-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar - Fixed Left (Hidden on mobile) -->
    <aside id="sidebar" class="fixed top-16 left-0 z-30 w-64 h-[calc(100vh-4rem)] bg-white border-r overflow-y-auto hidden md:block">
        <ul class="p-4 space-y-2">
            <li>
                <a href="<?= base_url('/') ?>" class="block px-4 py-2 rounded text-gray-600 font-semibold <?= current_url() == base_url('/') ? 'bg-blue-100 text-primary' : 'hover:bg-gray-100' ?>">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-house-door-fill"></i> Dashboard</a>
                </span>
            </li>
            <li>
                <a href="<?= session()->get('role') == 'admin' ? base_url('admin/barang') : base_url('barang') ?>"
                    class="block px-4 py-2 rounded text-gray-600 font-semibold <?= (url_is('*barang*') && !url_is('*kategori*')) ? 'bg-blue-100 text-primary' : 'hover:bg-gray-100' ?>">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-box-fill"></i> Barang
                    </span>
                </a>
            </li>

            <li>
                <a href="<?= base_url('petugas/stok') ?>" class="block px-4 py-2 rounded text-gray-600 font-semibold <?= (url_is('*stok*')) ? 'bg-blue-100 text-primary' : 'hover:bg-gray-100' ?>">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-box-arrow-in-down"></i> Transaksi Stok</a>
                </span>
            </li>
            <?php if (session()->get('role') == 'admin'): ?>
                <li>
                    <a href="<?= base_url('admin/barang/create') ?>" class="block px-4 py-2 rounded text-green-600 hover:bg-green-50">
                        <span class="flex items-center gap-2">
                            <i class="bi bi-plus-square-fill"></i> Tambah Barang</a>
                    </span>
                </li>
                <li>
                    <a href="<?= base_url('admin/kategori') ?>" class="block px-4 py-2 rounded text-gray-600 font-semibold <?= (url_is('*kategori*')) ? 'bg-blue-100 text-primary' : 'hover:bg-gray-100' ?>">
                        <span class="flex items-center gap-2">
                            <i class="bi bi-folder2-open"></i> Kategori</a>
                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- Konten Utama - Scrollable -->
    <main id="content" class="md:ml-64 pt-16 min-h-screen bg-gray-100">
        <div class="p-4 md:p-6">
            <!-- Flash Message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <!-- Render konten dari section -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer class="bg-white border-t py-3 text-center text-gray-500 text-sm">
        &copy; <?= date('Y') ?> InventoryApp - Sistem Manajemen Inventory
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('toggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    // Opsional: tambahkan padding dinamis di mobile jika sidebar terbuka
                });
            }
        });
    </script>
</body>

</html>