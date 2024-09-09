<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/Pegawai.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();

$post = new Pegawai($db);

$post->id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : die();
$posts = $post->sisacuti();

// Get Rows Count
$rows = $posts->rowCount();




// Get Rows Count
if ($rows > 0) {
    // Posts Available
    $postsArr = [];

    while ($row = $posts->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $postItem = [
            "pegawai_nip" => $pegawai_nip,
            "pegawai_nama" => $pegawai_nama,
            "Departemen" => $departemen,
            "Cuti_tetpakai" => $totcuti,
            "Jatah_cuti" => $jatah_cuti,
            "Sisa_cuti" => $sisa,

        ];
        array_push($postsArr, $postItem);
    } // Turn posts array into JSON and display it
    echo json_encode($postsArr, JSON_PRETTY_PRINT);
}

