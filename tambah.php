<?php
session_start();

if(!isset($_SESSION["login"]) ) {
		header("location: login.php");
		exit;
}

require 'functions.php';


// cek apakah tombol submit talah di tekan atau beleum
if( isset($_POST["submit"]) ) {


	// cek apakah data berhasil di tambah data atau tidak
	if( tambah($_POST) > 0 ) {
		echo "
		<script>
			alert('data berhasil ditamb	ahkan!');
			document.location.href = 'index.php';
		</script>
		";
	} else {
		echo "
		<script>
			alert('data gagal ditambahkan!');
			document.location.href = 'index.php';
		</script>
		";
	}

}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah Data Mahasiswa</title>
</head>
<body>
	<h1>Tambah Data Mahasiswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="nama">Nama : </label>
				<input type="text" name="nama" id="nama" required>
			</li>
			<li>
				<label for="nobp">Nobp : </label>
				<input type="text" name="nobp" id="nobp" required>
			</li>
			<li>
				<label for="email">Email : </label>
				<input type="text" name="email" id="email" required>
			</li>
			<li>
				<label for="jurusan">Jurusan : </label>
				<input type="text" name="jurusan" id="jurusan" required>
			</li>
			<li>
				<label for="gambar">Gambar : </label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit">Tambah Data</button>
			</li>
		</ul>

	</form>

</body>
</html>
