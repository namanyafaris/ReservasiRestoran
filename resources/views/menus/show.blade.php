<x-guest-layout>
    <section class="container my-5">
        <style>
            .fixed-image {
                width: 600px;
                height: 430px;
                object-fit: cover;
                object-position: center;
                border-radius: 1rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ ($menu->image) }}" class="img-fluid rounded shadow fixed-image" />
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">{{ $menu->name }}</h2>
                <p class="text-muted">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                <p>{{ $menu->description }}</p>
                {{-- Rating Section --}}
                <div>
                    <div class="d-flex align-items-center">
                        <span class="me-2 fw-semibold">Rating:</span>
                        <div>
                            @for ($i = 1; $i <= 10; $i++)
                                @if($i <=round($menu->rating))
                                <span class="text-warning" style="font-size: 1.5em;">&#9733;</span>
                                @else
                                <span class="text-secondary" style="font-size: 1.5em;">&#9733;</span>
                                @endif
                                @endfor
                        </div>
                        <span class="ms-2 badge bg-light text-dark border">
                            {{ number_format($menu->rating, 1) }} / 10
                        </span>
                    </div>
                    {{-- Tambahkan atribut lain di sini --}}
                    <p><strong>Kategori:</strong>
                        @foreach ($menu->categories as $category)
                        <span class="badge bg-warning text-dark">{{ $category->name }}</span>
                        @endforeach
                    </p>

                    <a href="{{ route('menus.index') }}" class="btn btn-secondary mt-3">Kembali ke Katalog</a>
                </div>

            </div>
        </div>
    </section>
</x-guest-layout>