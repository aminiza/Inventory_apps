<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi Stok</h1>
    <a href="<?= base_url("/petugas/stok/create") ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>Tambah Transaksi</a>
</div>

<div class="mb-6">
    <div class="relative">
        <div class="absolute inset-y-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="text" id="searchInput" placeholder="Cari kode barang, nama, atau keterangan" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
        <button id="resetInput" class="absolute inset-y-0 pr-3 right-0 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<div id="searchResult">
    <?= view('petugas/stok/_table', [
        'transaksi' => $transaksi,
        'total' => $total,
        'search' => $search
    ]) ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const searchResult = document.getElementById('searchResult');
        const resetInput = document.getElementById('resetInput');
        let searchTimeout;

        const performSearch = (searchTerm = '', page = 1) => {
            // Update URL
            const url = new URL(window.location);
            if (searchTerm) url.searchParams.set('search', searchTerm);
            else url.searchParams.delete('search');
            url.searchParams.set('page_stok', page);
            window.history.replaceState({}, '', url);

            // Loading state
            searchResult.innerHTML = `
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-4 text-gray-600">Memuat data...</p>
                </div>
            `;

            fetch(`<?= base_url('/petugas/stok/search') ?>?search=${encodeURIComponent(searchTerm)}&page_stok=${page}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.html) {
                        searchResult.innerHTML = data.html;
                    } else {
                        throw new Error('Format response tidak valid');
                    }
                })
                .catch(error => {
                    console.error('Search Error:', error);
                    searchResult.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                            <p class="text-red-600 font-medium">Gagal memuat data: ${error.message}</p>
                            <button onclick="location.reload()" class="mt-3 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Muat Ulang Halaman
                            </button>
                        </div>
                    `;
                });
        }

        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            const searchTerm = searchInput.value.trim();

            // Toggle reset button
            resetInput.classList.toggle('hidden', searchTerm === '');

            if(searchTerm.length < 3) {
                performSearch('');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 400);
        });

        searchInput.addEventListener('keydown', (e) => {
            if(e.key === "Enter") {
                e.preventDefault();
                clearTimeout(searchTimeout);
                performSearch(searchInput.value.trim());
            }
        });

        resetInput.addEventListener('click', () => {
            searchInput.value = '';
            performSearch('');
            resetInput.classList.add('hidden');
        });

        // Event delegation untuk pagination
        document.addEventListener('click', (e) => {
            const link = e.target.closest('.pagination a, [data-page]');
            
            if (link) {
                e.preventDefault();
                const url = new URL(link.href);
                const search = url.searchParams.get('search') || searchInput.value.trim();
                const page = url.searchParams.get('page_stok') || link.dataset.page || 1;
                performSearch(search, page);
            }
        });

        // Load initial state dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const initialSearch = urlParams.get('search') || '';
        const initialPage = urlParams.get('page_stok') || 1;
        
        if (initialSearch) {
            searchInput.value = initialSearch;
            resetInput.classList.remove('hidden');
        }
    });
</script>
<?= $this->endSection() ?>