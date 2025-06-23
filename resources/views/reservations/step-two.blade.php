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
                        <div class="col-md-12">
    <label class="form-label">Pilih Menu & Jumlah</label>
    <div id="menu-list">
        @foreach($menus as $menu)
        <div class="input-group mb-2 menu-item" data-menu-id="{{ $menu->id }}">
            <div class="input-group-text">
                <input type="checkbox" class="menu-checkbox" data-menu-id="{{ $menu->id }}" name="menu_id[]" value="{{ $menu->id }}">
            </div>
            <input type="text" class="form-control" value="{{ $menu->name }}" readonly>
            <input type="number" min="1" class="form-control menu-qty" data-menu-id="{{ $menu->id }}" name="quantity[{{ $menu->id }}]" placeholder="Jumlah" value="1">
        </div>
        @endforeach
        <!-- Nanti menu lintas kategori akan di-append di sini lewat JS -->
    </div>
    @error('menu_id')
    <p class="register_text_error text-danger">{{$message}}</p>
    @enderror
    @error('quantity')
    <p class="register_text_error text-danger">{{$message}}</p>
    @enderror
</div>
<small class="text-light">Centang dan isi jumlah menu yang ingin dipesan (menu dari kategori lain tetap tampil di bawah).</small>

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
$(document).ready(function() {
    const MENU_KEY = 'selected_menus_quantities';
    const allMenus = @json($allMenus);

    // Ambil data menu dari localStorage
    function getMenusFromLS() {
        return JSON.parse(localStorage.getItem(MENU_KEY) || '{}');
    }
    // Simpan data menu ke localStorage
    function setMenusToLS(data) {
        localStorage.setItem(MENU_KEY, JSON.stringify(data));
    }

    // Cek menu yg sudah dipilih & quantity, update localStorage setiap ada perubahan
    function updateLS() {
        let data = getMenusFromLS();
        $('.menu-checkbox').each(function() {
            let id = $(this).data('menu-id');
            if ($(this).is(':checked')) {
                let qty = $('.menu-qty[data-menu-id="' + id + '"]').val() || 1;
                data[id] = parseInt(qty);
            } else {
                delete data[id];
            }
        });
        setMenusToLS(data);
    }

    // Render ulang menu lintas kategori yang sudah dipilih (tapi tidak ada di kategori saat ini)
    function renderExtraMenus() {
        let data = getMenusFromLS();
        let menuList = $('#menu-list');
        // Hapus dulu menu-item yang bukan dari kategori aktif
        menuList.find('.extra-menu').remove();
        Object.keys(data).forEach(function(menuId) {
            if (!$('.menu-item[data-menu-id="' + menuId + '"]').length) {
                // Menu tsb tidak ada di kategori aktif, render di bawah
                let menuName = allMenus[menuId] || ('Menu #' + menuId);
                let html = `<div class="input-group mb-2 menu-item extra-menu" data-menu-id="${menuId}">
                    <div class="input-group-text">
                        <input type="checkbox" class="menu-checkbox" data-menu-id="${menuId}" name="menu_id[]" value="${menuId}" checked>
                    </div>
                    <input type="text" class="form-control" value="${menuName}" readonly>
                    <input type="number" min="1" class="form-control menu-qty" data-menu-id="${menuId}" name="quantity[${menuId}]" placeholder="Jumlah" value="${data[menuId]}">
                </div>`;
                menuList.append(html);
            }
        });
    }

    // Restore pilihan menu dari localStorage ke form
    function restoreFromLS() {
        let data = getMenusFromLS();
        $('.menu-checkbox').each(function() {
            let id = $(this).data('menu-id');
            if (data[id]) {
                $(this).prop('checked', true);
                $('.menu-qty[data-menu-id="' + id + '"]').val(data[id]);
            } else {
                $(this).prop('checked', false);
                $('.menu-qty[data-menu-id="' + id + '"]').val(1);
            }
        });
        // Render extra menu
        renderExtraMenus();
    }

    // Event: checkbox/qty berubah
    $(document).on('change', '.menu-checkbox, .menu-qty', function() {
        updateLS();
    });

    // Saat halaman load, restore data
    restoreFromLS();

    // Saat kategori berubah (ganti page), tunggu render, lalu restore menu
    $('#category_id').on('change', function() {
        setTimeout(function() {
            restoreFromLS();
        }, 500);
    });

    // Meja tetap seperti kode Anda
    $('#table_id').on('change', function() {
        localStorage.setItem('selected_table_id', $(this).val());
    });
    if (localStorage.getItem('selected_table_id')) {
        $('#table_id').val(localStorage.getItem('selected_table_id')).trigger('change');
    }
    $('#category_id').on('change', function() {
        if (localStorage.getItem('selected_table_id')) {
            $('#table_id').val(localStorage.getItem('selected_table_id')).trigger('change');
        }
    });
});
</script>

</x-guest-layout>