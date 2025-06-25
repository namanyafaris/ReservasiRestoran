<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Data Semua Reservasi</title>
	<style>
		body {
			font-family: sans-serif;
			font-size: 12px;
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
	<h2>Data Semua Reservasi</h2>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nama</th>
				<th>Tanggal</th>
				<th>Jumlah Tamu</th>
				<th>Meja</th>
				<th>Menu</th>
			</tr>
		</thead>
		<tbody>
			@foreach($reservations as $reservation)
			<tr>
				<td>{{ $reservation->id }}</td>
				<td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
				<td>{{ $reservation->res_date }}</td>
				<td>{{ $reservation->guest_number }}</td>
				<td>{{ $reservation->table->name ?? '-' }}</td>
				<td>
					@if($reservation->menus && $reservation->menus->count())
					@foreach($reservation->menus as $menu)
					{{ $menu->name }} ({{ $menu->pivot->quantity }})<br>
					@endforeach
					@else
					-
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>