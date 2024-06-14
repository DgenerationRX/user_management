<?php
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
