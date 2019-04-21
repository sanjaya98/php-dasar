<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


function query ($query) {
	global $conn;
 	$result = mysqli_query($conn, $query);
 	$rows = [];
 	while( $row = mysqli_fetch_assoc($result) ) {
 		$rows[] = $row;
 	}
 	return $rows;
}


function tambah ( $data) {
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$nobp = htmlspecialchars($data["nobp"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	// Upload Gambar
	$gambar = upload();
	if( !$gambar ) {
		return false;
	}

	// query inserta data
	$query = "INSERT INTO mahasiswa
				VALUES
				('', '$nama', '$nobp', '$email', '$jurusan', '$gambar')
				";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);

	}


function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apak tidak gambar yg di upload
	if( $error === 4 ) {
		echo "<script>
						alert('Pilih gambar terlebih dahulu!');
					</script>";
		return false;
	}

	// cek apakah yang diupload adalah Gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode( '.', $namaFile );
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid ) ) {
		echo "<script>
						alert('Yang anda upload bukan gambar!');
					</script>";
		return false;
	}

	// cek jika ukuran gambar terlalu besar
	if ( $ukuranFile > 3000000 ) {
		echo "<script>
						alert('Ukuran gambar terlalu besar!');
					</script>";
		return false;
	}

	// lolos pengecekan, gambar siao diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;


}


function hapus ($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

	return mysqli_affected_rows($conn);

}

function ubah ($data) {
	global $conn;

	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$nobp = htmlspecialchars($data["nobp"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	//  cek apkah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
			$gambar = upload();
	}

	$query = "UPDATE mahasiswa SET
				nama = '$nama',
				nobp = '$nobp',
				email = '$email',
				jurusan = '$jurusan',
				gambar = '$gambar'
				WHERE id = $id
				";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function cari($keyword) {
	$query = "SELECT * FROM mahasiswa
				WHERE
				nama LIKE '%$keyword%' OR
				nobp LIKE '%$keyword%' OR
				email LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%'

				";
	return query($query);
}


function registrasi ($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	//  cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

		if (mysqli_fetch_assoc($result)) {
			echo "<script>
	          alert('username sudah terdaftar! ');
	          </script>";
			return false;
		}

	// cek komfirmasi password
	if ( $password !== $password2 ) {
		echo "<script>
          alert('konfirmasi password tidak sesuai!');
          </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambah data ke database
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

	return mysqli_affected_rows($conn);


}







?>
