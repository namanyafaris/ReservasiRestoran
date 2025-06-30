<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Daftar Semua Meja</title>
	<style>
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 12px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th,
		td {
			border: 1px solid #333;
			padding: 6px 8px;
			text-align: left;
		}

		th {
			background: #f2f2f2;
		}

		h2 {
			text-align: center;
		}
	</style>
</head>

<body>
	<h2>Daftar Semua Meja</h2>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Meja</th>
				<th>Jumlah Kursi</th>
				<th>Status</th>
				<th>Lokasi</th>
			</tr>
		</thead>
		<tbody>
			@foreach($tables as $i => $table)
			<tr>
				<td>{{ $i+1 }}</td>
				<td>{{ $table->name }}</td>
				<td>{{ $table->guest_number }}</td>
				<td>{{ $table->status }}</td>
				<td>{{ $table->location }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>