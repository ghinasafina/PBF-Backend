<h1>Daftar Mahasiswa</h1>
<table>
    <tr>
        <th>NPM</th>
        <th>Nama Mahasiswa</th>
        <th>Alamat</th>
        <th>Kelas</th>
        <th>Tahun Akademik</th>
        <th>Prodi</th>
        <th>Jurusan</th>
    </tr>
    <?php foreach ($mahasiswa as $m): ?>
    <tr>
        <td><?= $m['NPM'] ?></td>
        <td><?= $m['nama_mahasiswa'] ?></td>
        <td><?= $m['alamat'] ?></td>
        <td><?= $m['kelas'] ?></td>
        <td><?= $m['tahun_akademik'] ?></td>
        <td><?= $m['id_prodi'] ?></td>
        <td><?= $m['id_jurusan'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="/mahasiswa/create">Tambah Mahasiswa</a>