@extends('layouts.backend.master')

@section('title', 'Edit Reservasi — Restawrant')
@section('content')

    @push('create-article-styles')
        <link rel="stylesheet" type="text/css" href="{{ url('cuba/assets/css/vendors/select2.css') }}">
    @endpush

    <div class="container-fluid">
        <div class="page-title">
            <div class="card card-absolute mt-5 mt-md-4">
                <div class="card-header bg-primary">
                    <h5 class="text-white">🍕 • Edit Reservasi</h5>
                </div>
                <div class="card-body">
                    <p>Halaman untuk mengedit data reservasi. Menu yang telah kamu tambahkan nantinya muncul di landing page.</p>
                </div>
            </div>
        </div>
        <!-- main content start-->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Reservasi</h5>
                    </div>
                    <div class="card-body add-post">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    <li>
                                        <h4>Ada error nih 😓</h4>
                                    </li>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="row" method="POST"
                            action="{{ route('admin.reservations.update', $reservation->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-sm-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">Nama Depan: <span class="text-danger">*</span></label>
                                        <input class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name', $reservation->first_name) }}" type="text" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Nama Belakang: <span class="text-danger">*</span></label>
                                        <input class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name', $reservation->last_name) }}" type="text" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="email">Email: <span class="text-danger">*</span></label>
                                        <input class="form-control" id="email" name="email"
                                            value="{{ old('email', $reservation->email) }}" type="email" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tel_number">Nomor Telepon: <span class="text-danger">*</span></label>
                                        <input class="form-control" id="tel_number" name="tel_number"
                                            value="{{ old('tel_number', $reservation->tel_number) }}" type="text" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="guest_number">Jumlah Tamu</label>
                                        <input class="form-control" id="guest_number" name="guest_number"
                                            value="{{ old('guest_number', $reservation->guest_number) }}" type="number" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="res_date">Tanggal Reservasi</label>
                                        <input type="datetime-local"
                                            value="{{ old('res_date', $reservation->res_date->format('Y-m-d\TH:i:s')) }}"
                                            id="res_date" name="res_date" class="form-control" required>
                                        @error('res_date')
                                            <p class="register_text_error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="table_id">Meja: <span class="text-danger">*</span></label>
                                        <select id="table_id" name="table_id" class="custom-select" required>
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->id }}" @selected(old('table_id', $reservation->table_id) == $table->id)>
                                                    {{ $table->name }} ({{ $table->guest_number }} Guests)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
    <label>Menu yang Dipilih & Jumlah</label>
    @foreach($menus as $menu)
        <div class="input-group mb-2">
            <div class="input-group-text">
                <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}"
                    {{ in_array($menu->id, old('menu_id', $reservation->menus->pluck('id')->toArray())) ? 'checked' : '' }}>
            </div>
            <input type="text" class="form-control" value="{{ $menu->name }}" readonly>
            <input type="number" min="1" class="form-control" name="quantity[{{ $menu->id }}]"
                placeholder="Jumlah"
                value="{{ old('quantity.' . $menu->id, optional($reservation->menus->find($menu->id))->pivot->quantity ?? 1) }}">
        </div>
    @endforeach
    <small class="text-muted">Centang menu & isi jumlah yang diinginkan.</small>
    @error('menu_id')
        <p class="register_text_error text-danger">{{ $message }}</p>
    @enderror
    @error('quantity')
        <p class="register_text_error text-danger">{{ $message }}</p>
    @enderror
</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="btn-showcase">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    <input class="btn btn-light" type="reset" value="Reset">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content end-->
    </div>

    @push('create-article-scripts')
        <script src="{{ url('cuba/assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#menu_id').select2({
                    placeholder: "Pilih menu",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush

@endsection