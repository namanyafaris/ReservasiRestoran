<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Struk Reservasi</title>
	<style>
		body {
			font-family: sans-serif;
			font-size: 14px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		th,
		td {
			border: 1px solid #ccc;
			padding: 6px;
		}
	</style>
</head>

<body>
	<h2>Struk Reservasi Restoran Fensi</h2>
	<p><strong>Nama:</strong> {{ $reservation->first_name ?? '' }} {{ $reservation->last_name ?? '' }}</p>
	<p><strong>Tanggal / Waktu:</strong> {{ $reservation->res_date ? \Carbon\Carbon::parse($reservation->res_date)->format('d-m-Y H:i') : '-' }}</p>
	<p><strong>Meja:</strong> {{ $reservation->table->name ?? '-' }}</p>
	<p><strong>Jumlah Tamu:</strong> {{ $reservation->guest_number ?? '-' }}</p>
	<hr>
	<h4>Menu Dipesan:</h4>
	<table>
		<tr>
			<th>Menu</th>
			<th>Jumlah</th>
		</tr>
		@foreach($reservation->menus as $menu)
		<tr>
			<td>{{ $menu->name }}</td>
			<td>{{ $menu->pivot->quantity}}</td>
		</tr>
		@endforeach
	</table>
</body>

</html>