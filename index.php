<?php
session_start();

if(!isset($_SESSION["login"]) ) {
		header("location: login.php");
		exit;
}

require 'functions.php';

$mahasiswa = query ("SELECT * FROM mahasiswa");

// tombol cari ditekan
if(isset($_POST["cari"]) ) {
	$mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Halaman Admin</title>
</head>
<body>

<a href="logout.php">Loguot</a>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php">Tambah Data Mahasiswa</a>
<br><br>

<form action="" method="post">

	<input type="text" name="keyword" size="40" autofocus placeholder="Masukan Keyword Pencarian.." autocomplete="off">
	<button type="submit" name="cari">Cari!</button>

</form>
<br>

<table border="1" cellpadding="10" cellspacing="0">
	<tr>
		<th>No.</th>
		<th>Aksi</th>
		<th>Gambar</th>
		<th>Nobp</th>
		<th>Nama</th>
		<th>Email</th>
	 	<th>Jurusan</th>
	</tr>

	<?php $i = 1; ?>
	<?php foreach( $mahasiswa as $mhs) : ?>
		<tr>
			<td><?= $i; ?></td>
			<td>
				<a href="ubah.php?id=<?= $mhs["id"]; ?>">ubah</a> |
				<a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('yakin ingin menghapus?');">hapus</a>
			</td>
			<td><img src="img/<?= $mhs["gambar"]; ?>" width="50">
			</td>
			<td><?= $mhs["nobp"]; ?></td>
			<td><?= $mhs["nama"]; ?></td>
			<td><?= $mhs["email"]; ?></td>
			<td><?= $mhs["jurusan"]; ?></td>
		</tr>
	<?php $i++; ?>
	<?php endforeach; ?>

</table>


</body>
</html>
