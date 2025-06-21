<x-guest-layout>
    <section class="my-5">
        <div class="container">
            <div class="row my-4 mx-1">
                <div class="col-md-12 mx-auto bg-warning text-white p-md-5 p-4 shadow-lg rounded-3">
                    <small>RESERVASI RESTAWRANT</small>
                    <h1 class="fw-bold">Reservasi Tempat Meja di Restawrant</h1>
                    <p>Pilih meja dan menu untuk reservasi tempat di Restawrant</p>
                    <hr />

                    <!-- Form GET Pilih Kategori -->
                    <form method="GET" action="{{ route('reservations.step.two') }}" class="mb-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Pilih Kategori Menu</label>
                            <select name="category_id" id="category_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($selectedCategoryId==$category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <!-- Form POST Reservasi dan Menu (tampil setelah kategori dipilih) -->
                    @if($selectedCategoryId && count($menus))
                    <form method="POST" action="{{ route('reservations.store.step.two') }}" class="row g-3">
                        @csrf

                        <!-- Pilih Meja -->
                        <div class="col-md-12">
                            <label for="table_id" class="form-label">Pilih Meja</label>
                            <select name="table_id" id="table_id" class="form-select">
                                <option value="">Pilih Meja ...</option>
                                @forelse ($tables as $table)
                                <option value="{{ $table->id }}" @selected(old('table_id', $reservation->table_id ?? '') == $table->id)>
                                    {{ $table->name }} ({{ $table->guest_number }} Tamu)
                                </option>
                                @empty
                                <option value="">Tidak ada meja yang tersedia :</option>
                                @endforelse
                            </select>
                            @error('table_id')
                            <p class="register_text_error text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hidden category id -->
                        <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">

                        <!-- Pilih Menu -->
                        <div class="col-md-12">
    <label class="form-label">Pilih Menu & Jumlah</label>
    @foreach($menus as $menu)
        <div class="input-group mb-2">
            <div class="input-group-text">
                <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}"
                    {{ is_array(old('menu_id')) && in_array($menu->id, old('menu_id')) ? 'checked' : '' }}>
            </div>
            <input type="text" class="form-control" value="{{ $menu->name }}" readonly>
            <input type="number" min="1" class="form-control" name="quantity[{{ $menu->id }}]"
                placeholder="Jumlah"
                value="{{ old('quantity.' . $menu->id, 1) }}">
        </div>
    @endforeach
    @error('menu_id')
    <p class="register_text_error text-danger">{{$message}}</p>
    @enderror
    @error('quantity')
    <p class="register_text_error text-danger">{{$message}}</p>
    @enderror
</div>
<small class="text-light">Centang dan isi jumlah menu yang ingin dipesan.</small>

                        <!-- Tombol Submit -->
                        <div class="col-md-12 mx-auto mt-4 text-center">
                            <p class="text-center col-md-8 mx-auto">
                                Dengan menekan tombol 'buat reservasi' berarti anda menyatakan setuju dan siap
                                bertanggung jawab atas reservasi yang anda telah buat.
                            </p>
                            <a href="{{ route('reservations.step.one') }}"
                                class="btn btn-outline-light text-white px-5 py-2 fw-bold me-3">
                                <i class="fas fa-arrow-left"></i> &nbsp; Sebelumnya
                            </a>
                            <button type="submit" class="btn btn-outline-light text-white px-5 py-2 fw-bold">
                                Buat Reservasi &nbsp; <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const allMenus = @json($allMenus);
        $(document).ready(function() {
            $('#menu_id').select2({
                placeholder: "Pilih Menu",
                allowClear: true,
                width: '100%'
            });

            // Ambil semua menu yang pernah dipilih dari localStorage
            function getAllSelectedMenus() {
                return JSON.parse(localStorage.getItem('selected_menus_all') || '[]');
            }

            // Simpan semua menu yang dipilih ke localStorage
            function setAllSelectedMenus(arr) {
                localStorage.setItem('selected_menus_all', JSON.stringify(arr));
            }

            // Saat menu dipilih/dihapus, update localStorage
            $('#menu_id').on('change', function() {
                let currentSelected = $(this).val() || [];
                setAllSelectedMenus(currentSelected);
            });

            // Saat kategori berubah, tambahkan option untuk menu yang sudah dipilih
            $('#category_id').on('change', function() {
                let allSelected = getAllSelectedMenus();
                // Tambahkan option jika belum ada di select
                allSelected.forEach(function(menuId) {
                    if ($('#menu_id option[value="' + menuId + '"]').length === 0) {
                        let menuName = allMenus[menuId] || ('Menu #' + menuId);
                        $('#menu_id').append('<option value="' + menuId + '" selected>' + menuName + '</option>');
                    }
                });
                // Set value select2
                setTimeout(function() {
                    $('#menu_id').val(allSelected).trigger('change');
                }, 300);
            });

            // Saat halaman load, tambahkan option untuk menu yang sudah dipilih
            let allSelected = getAllSelectedMenus();
            allSelected.forEach(function(menuId) {
                if ($('#menu_id option[value="' + menuId + '"]').length === 0) {
                    let menuName = allMenus[menuId] || ('Menu #' + menuId);
                    $('#menu_id').append('<option value="' + menuId + '" selected>' + menuName + '</option>');
                }
            });
            $('#menu_id').val(allSelected).trigger('change');

            // Simpan pilihan meja ke localStorage saat berubah
            $('#table_id').on('change', function() {
                localStorage.setItem('selected_table_id', $(this).val());
            });

            // Saat halaman load, set value meja dari localStorage jika ada
            if (localStorage.getItem('selected_table_id')) {
                $('#table_id').val(localStorage.getItem('selected_table_id')).trigger('change');
            }

            // Saat kategori berubah, tetap set value meja dari localStorage
            $('#category_id').on('change', function() {
                if (localStorage.getItem('selected_table_id')) {
                    $('#table_id').val(localStorage.getItem('selected_table_id')).trigger('change');
                }
            });
        });
    </script>

</x-guest-layout>