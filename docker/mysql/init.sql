CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','OPERATOR') NOT NULL DEFAULT 'OPERATOR',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(email)
);

-- Seed: Users (password = 'password' for both)
-- Hash from Laravel default for 'password': $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9G7RA3o1Ku9uJp/1VQ.Uu
INSERT INTO users (username,name,email,password_hash,role) VALUES
('admin','Administrator','admin@gmail.com','$2y$10$My1Mv3.qVBLo1/fcbKkMXeoH7s9nPr.uFrPvEXd5tXCepgjErHbqy','ADMIN'),
('operator','Operator','operator@gmail.com','$2y$10$My1Mv3.qVBLo1/fcbKkMXeoH7s9nPr.uFrPvEXd5tXCepgjErHbqy','OPERATOR');

-- Schema: Domain
CREATE TABLE IF NOT EXISTS kelas (
    id_kelas INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50) NOT NULL,
    tingkat INT NOT NULL
);

CREATE TABLE IF NOT EXISTS siswa (
    nis VARCHAR(20) PRIMARY KEY,
    id_kelas INT NOT NULL,
    nama_siswa VARCHAR(150) NOT NULL,
    jekel ENUM('L', 'P') NOT NULL,
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_siswa_kelas FOREIGN KEY (id_kelas) REFERENCES kelas(id_kelas) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50) NOT NULL,
    lokasi VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS buku (
    kode_buku VARCHAR(50) PRIMARY KEY,
    id_rak INT NOT NULL,
    judul_buku VARCHAR(200) NOT NULL,
    pengarang VARCHAR(150),
    penerbit VARCHAR(150),
    tahun_terbit INT,
    stok INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_buku_rak FOREIGN KEY (id_rak) REFERENCES rak(id_rak) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS peminjaman (
    id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nis VARCHAR(20) NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NULL,
    status ENUM('pinjam', 'kembali') DEFAULT 'pinjam',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pinjam_user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_pinjam_siswa FOREIGN KEY (nis) REFERENCES siswa(nis) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS detail_peminjaman (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_peminjaman INT NOT NULL,
    kode_buku VARCHAR(50) NOT NULL,
    denda INT DEFAULT 0,
    CONSTRAINT fk_detail_pinjam FOREIGN KEY (id_peminjaman) REFERENCES peminjaman(id_peminjaman) ON DELETE CASCADE,
    CONSTRAINT fk_detail_buku FOREIGN KEY (kode_buku) REFERENCES buku(kode_buku) ON DELETE CASCADE
);


-- Seed: Kelas
INSERT INTO kelas (nama_kelas, tingkat) VALUES
('V A', 5),
('VI A', 6),
('III A', 3);

-- Seed: Siswa (10 records)
INSERT INTO siswa (nis, id_kelas, nama_siswa, jekel, alamat) VALUES
('1001', 1, 'Ahmad Fauzi', 'L', 'Jl. Cemara No.1'),
('1002', 1, 'Budi Santoso', 'L', 'Jl. Mawar No.2'),
('1003', 1, 'Citra Dewi', 'P', 'Jl. Melati No.3'),
('1004', 2, 'Dodi Pratama', 'L', 'Jl. Dahlia No.4'),
('1005', 2, 'Eva Lestari', 'P', 'Jl. Kenanga No.5'),
('1006', 2, 'Fajar Hidayat', 'L', 'Jl. Anggrek No.6'),
('1007', 3, 'Gita Permata', 'P', 'Jl. Teratai No.7'),
('1008', 3, 'Hendra Wijaya', 'L', 'Jl. Kamboja No.8'),
('1009', 3, 'Intan Sari', 'P', 'Jl. Tulip No.9'),
('1010', 3, 'Joko Saputra', 'L', 'Jl. Flamboyan No.10');

-- Seed: Rak (5 records)
INSERT INTO rak (nama_rak, lokasi) VALUES
('Referensi', 'Lantai 1'),
('Fiksi', 'Lantai 1'),
('Non Fiksi', 'Lantai 2'),
('Sains', 'Lantai 2'),
('Sejarah', 'Lantai 3');

-- Seed: Buku (20 records)
INSERT INTO buku (kode_buku, id_rak, judul_buku, pengarang, penerbit, tahun_terbit, stok) VALUES
('BK0001', 1, 'Ensiklopedia Indonesia', 'Tim Editor', 'Pustaka Nusantara', 2015, 5),
('BK0002', 1, 'Kamus Besar Bahasa Indonesia', 'Balai Pustaka', 'Balai Pustaka', 2016, 4),
('BK0003', 2, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang', 2005, 6),
('BK0004', 2, 'Negeri 5 Menara', 'A. Fuadi', 'Gramedia', 2011, 7),
('BK0005', 2, 'Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 'Republika', 2004, 3),
('BK0006', 3, 'Mudah Memahami Akuntansi', 'S. Sugiyono', 'Salemba', 2018, 5),
('BK0007', 3, 'Psikologi Umum', 'Suryabrata', 'Rajawali', 2012, 4),
('BK0008', 3, 'Seni Berbicara', 'Dale Carnegie', 'Simon & Schuster', 2010, 5),
('BK0009', 4, 'Fisika Dasar', 'Halliday & Resnick', 'Erlangga', 2014, 8),
('BK0010', 4, 'Kimia Dasar', 'Raymond Chang', 'Erlangga', 2013, 6),
('BK0011', 4, 'Biologi Umum', 'Campbell', 'Pearson', 2012, 4),
('BK0012', 4, 'Matematika Diskrit', 'Rosen', 'McGraw-Hill', 2011, 5),
('BK0013', 5, 'Sejarah Indonesia Modern', 'MC Ricklefs', 'Macmillan', 2008, 3),
('BK0014', 5, 'Perang Dunia II', 'Antony Beevor', 'Penguin', 1998, 4),
('BK0015', 5, 'Kerajaan Majapahit', 'Pigeaud', 'KITLV', 2009, 2),
('BK0016', 2, 'Bumi', 'Tere Liye', 'Gramedia', 2014, 9),
('BK0017', 2, 'Hujan', 'Tere Liye', 'Gramedia', 2016, 7),
('BK0018', 3, 'Seni Berpikir Kreatif', 'Edward de Bono', 'HarperCollins', 2000, 3),
('BK0019', 4, 'Cerdas Menghadapi Olimpiade Sains', 'Tim Olimpiade', 'Erlangga', 2017, 5),
('BK0020', 1, 'Atlas Dunia', 'National Geographic', 'NatGeo', 2019, 6);
