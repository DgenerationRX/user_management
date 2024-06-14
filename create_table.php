<?php
// Buat koneksi ke database SQLite
$db = new SQLite3('example.db');

// Buat tabel jika belum ada
$query = "
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nim INTEGER, 
    name TEXT, 
    kelas TEXT,
    nilai INTEGER,
    grade TEXT
)";
$db->exec($query);

    echo "Table created successfully.";
?>