<x-guest-layout>

    <!-- ------------------------ Menu Hero Section ------------------------ -->
    <section>
        <div class="container">
            <div class="mt-4 mt-md-0 mb-3 bg-warning text-white rounded-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 p-5 my-auto align-center">
                            <h1 class="display-5 fw-bold">Katalog Menu Makanan & Minuman Restawrant</h1>
                            <p class="col-md-10">
                                Disini kalian bisa nemuin semua menu dengan berbagai macam kategori yang dapat kalian
                                pesan
                                di restoran kami, scroll kebawah ya!
                            </p>
                            <button class="btn btn-outline-light text-white px-4 fw-bold" type="button">
                                Lihat semua &nbsp; <i class="fas fa-arrow-down"></i>
                            </button>
                        </div>
                        <div class="col-md-4 my-auto p-0">
                            <img src="{{ url('images/landing-page/user-listing-images-removebg-preview-2.png') }}"
                                class="img-fluid img-jumbotron d-none d-md-block" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ------------------------ Menu Main Content [Filter & Menu Card] Section ------------------------ -->
    <section>
        <div class="container" style="margin-bottom: 100px">
            <div class="row g-3">
                <div class="col-md-4 mb-3 d-none d-md-block">
                    <div class="flex-shrink-0 p-3 bg-warning rounded-3 sticky-top menu-filter">
                        <a href="/"
                            class="
                    d-flex
                    align-items-center
                    pb-3
                    mb-3
                    link-light
                    text-decoration-none
                    border-bottom
                  ">
                            <span class="fs-5 fw-semibold">Filter</span>
                        </a>
                        <form method="GET" action="{{ route('menus.index') }}">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                @foreach ($categories as $category)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" id="cat{{ $category->id }}"
                                            {{ in_array($category->id, request()->get('categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="mt-3">
                                <label class="fw-semibold">Urutan Harga</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort" id="sort_asc" value="asc"
                                        {{ request('sort') == 'asc' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sort_asc">
                                        Terendah — Tertinggi
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort" id="sort_desc" value="desc"
                                        {{ request('sort') == 'desc' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sort_desc">
                                        Tertinggi — Terendah
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light btn-sm mt-3">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="alert alert-warning" role="alert">
                        Terdapat total {{ DB::table('menus')->count() }} menu yang tersedia di katalog menu restoran
                        kami
                    </div>
                    <div class="row g-3">
                        @foreach ($menus as $menu)
                        <div class="col-md-4">
                            <div class="card card-borderless-shadow card-min-height">
                                @php
                                $image = Str::startsWith($menu->image, ['http://', 'https://'])
                                ? $menu->image
                                : Storage::url($menu->image);
                                @endphp
                                <img src="{{ ($image) }}"
                                    class="card-img-top card-img-top-menus" />
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"> {{ $menu->name }}</h5>
                                    <hr>
                                    <h5 class="fw-semibold">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </h5>
                                    <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-warning w-100 mt-2 fw-semibold">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>