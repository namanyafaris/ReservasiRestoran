<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Daftar Menu</title>
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

		img {
			max-width: 60px;
			max-height: 60px;
		}
	</style>
</head>

<body>
	<h2>Daftar Menu Makanan & Minuman</h2>
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Menu</th>
				<th>Deskripsi</th>
				<th>Harga</th>
			</tr>
		</thead>
		<tbody>
			@foreach($menus as $i => $menu)
			<tr>
				<td>{{ $i+1 }}</td>

				<td>{{ $menu->name }}</td>
				<td>{!! $menu->description !!}</td>
				<td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>

			</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>