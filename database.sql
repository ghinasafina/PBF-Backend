-- Buat database
CREATE DATABASE IF NOT EXISTS sistem_nilai_mahasiswa;
USE sistem_nilai_mahasiswa;

-- Tabel Jurusan
CREATE TABLE IF NOT EXISTS Jurusan (
    id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100) NOT NULL
);

-- Tabel Prodi
CREATE TABLE IF NOT EXISTS Prodi (
    id_prodi INT AUTO_INCREMENT PRIMARY KEY,
    nama_prodi VARCHAR(100) NOT NULL,
    id_jurusan INT,
    FOREIGN KEY (id_jurusan) REFERENCES Jurusan(id_jurusan)
);

-- Tabel Mahasiswa
CREATE TABLE IF NOT EXISTS Mahasiswa (
    NPM VARCHAR(20) PRIMARY KEY,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    alamat TEXT,
    kelas VARCHAR(10),
    tahun_akademik VARCHAR(10),
    id_prodi INT,
    FOREIGN KEY (id_prodi) REFERENCES Prodi(id_prodi)
);

-- Tabel Mata Kuliah
CREATE TABLE IF NOT EXISTS MataKuliah (
    id_matkul INT AUTO_INCREMENT PRIMARY KEY,
    nama_matkul VARCHAR(100) NOT NULL,
    sks INT NOT NULL,
    semester INT NOT NULL
);

-- Tabel Dosen
CREATE TABLE IF NOT EXISTS Dosen (
    id_dosen INT AUTO_INCREMENT PRIMARY KEY,
    nama_dosen VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_telp VARCHAR(15)
);

-- Tabel Nilai
CREATE TABLE IF NOT EXISTS Nilai (
    id_nilai INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT,
    id_matkul INT,
    NPM VARCHAR(20),
    nilai_akhir DECIMAL(5,2),
    FOREIGN KEY (id_dosen) REFERENCES Dosen(id_dosen),
    FOREIGN KEY (id_matkul) REFERENCES MataKuliah(id_matkul),
    FOREIGN KEY (NPM) REFERENCES Mahasiswa(NPM)
);

-- Tabel Detail Nilai
CREATE TABLE IF NOT EXISTS DetailNilai (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_nilai INT,
    nilai_tugas DECIMAL(5,2),
    nilai_uts DECIMAL(5,2),
    nilai_uas DECIMAL(5,2),
    FOREIGN KEY (id_nilai) REFERENCES Nilai(id_nilai)
);