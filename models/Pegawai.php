<?php
class Pegawai
{
    // DB Related
    private $conn;
    

    // Post Properties
    public $pegawai_nip;
    public $pegawainama;
    public $jabatan;
    // Construct with Database
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function read()
    {
        $query = "SELECT 
        c.pegawai_nama ,
        c.pegawai_nip,
        p.pembagian1_nama as departemen
        FROM pegawai as c
        LEFT JOIN
        pembagian1 as p ON c.pembagian1_id = p.pembagian1_id
        where p.pembagian1_id='4' and left(pegawai_nip,1)='1'
        ORDER BY pegawai_nip ASC
        lIMIT 4
        ";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        
        return $stmt;
        

        
    }

    public function sisacuti()
    {
        $query = "SELECT 
        c.pegawai_nama ,
        c.pegawai_nip,
        p.pembagian1_nama as departemen,
        count(d.izin_tgl) as totcuti,
        7 as jatah_cuti,
        @sisa := 7-(count(izin_tgl)) as sisa
        
        FROM pegawai as c
        LEFT JOIN
        pembagian1 as p ON c.pembagian1_id = p.pembagian1_id
        LEFT JOIN
        izin as d ON c.pegawai_id = d.pegawai_id
        WHERE d.izin_tgl > '2024-02-29' and p.pembagian1_id='4'
        AND LEFT(pegawai_nip,2)='10'
        AND d.izin_jenis_id IN ('90','70') 
        GROUP BY c.pegawai_nip
        ORDER BY c.pegawai_nip ASC
        LIMIT 0,1
        ";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);
         $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            // Get the category
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $post["id"];
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
        

        
    }

    
    // Get a Single Post
    

}    
