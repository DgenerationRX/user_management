<?php
// functions.php

function connect_db() {
    return new SQLite3('example.db');
}

function grade($nilai) {
    if ($nilai >= 85) {
        return 'A (Excellent)';
    } elseif ($nilai >= 70) {
        return 'B (Passed)';
    } elseif ($nilai >= 55) {
        return 'C (Fair)';
    } elseif ($nilai >= 40) {
        return 'D (Failed)';
    } else {
        return 'E (Error)';
    }
}

function add_user($nim, $name, $kelas, $nilai) {
    $db = connect_db();
    $grade = grade($nilai);
    $stmt = $db->prepare("INSERT INTO users (nim, name, kelas, nilai, grade) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $nim, SQLITE3_INTEGER);
    $stmt->bindValue(2, $name, SQLITE3_TEXT);
    $stmt->bindValue(3, $kelas, SQLITE3_TEXT);
    $stmt->bindValue(4, $nilai, SQLITE3_INTEGER);
    $stmt->bindValue(5, $grade, SQLITE3_TEXT);
    $stmt->execute();
}

function get_users() {
    $db = connect_db();
    $result = $db->query("SELECT * FROM users");
    $users = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $users[] = $row;
    }
    return $users;
}

function update_user($id, $nim, $name, $kelas, $nilai) {
    $db = connect_db();
    $grade = grade($nilai);
    $stmt = $db->prepare("UPDATE users SET nim = ?, name = ?, kelas = ?, nilai = ?, grade = ? WHERE id = ?");
    $stmt->bindValue(1, $nim, SQLITE3_INTEGER);
    $stmt->bindValue(2, $name, SQLITE3_TEXT);
    $stmt->bindValue(3, $kelas, SQLITE3_TEXT);
    $stmt->bindValue(4, $nilai, SQLITE3_INTEGER);
    $stmt->bindValue(5, $grade, SQLITE3_TEXT);
    $stmt->bindValue(6, $id, SQLITE3_INTEGER);
    $stmt->execute();
}

function delete_user($id) {
    $db = connect_db();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $stmt->execute();
}

function delete_all_users() {
    $db = connect_db();
    $stmt = $db->prepare("DELETE FROM users");
    if (!$stmt) {
        // Handle error here
        echo $db->lastErrorMsg();
        return;
    }
    $result = $stmt->execute();
    if (!$result) {
        // Handle error here
        echo $db->lastErrorMsg();
        return;
    }
    // Success message or further action
    echo "All users deleted successfully.";
}
?>

<?php
// backend.php

// Buat koneksi ke database SQLite dan buat tabel jika belum ada
$db = new SQLite3('example.db');
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

include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $kelas = $_POST['kelas'];
        $nilai = $_POST['nilai'];
        add_user($nim, $name, $kelas, $nilai);
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $kelas = $_POST['kelas'];
        $nilai = $_POST['nilai'];
        update_user($id, $nim, $name, $kelas, $nilai);
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        delete_user($id);
    }
}

$users = get_users();
?>
