<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiNilaiModel extends Model
{
    protected $table            = 'nilai_nilai';
    protected $primaryKey       = 'id_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_dosen', 'id_matkul', 'NPM'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function vw_dosen($id_matkul)
    {
        $sql = "SELECT
                    nilai_nilai.NPM,
                    mahasiswa.nama_mahasiswa,
                    mahasiswa.kelas,
                    detail_nilai.nilai_tugas,
                    detail_nilai.nilai_uts,
                    detail_nilai.nilai_uas,
                    MAX(CASE WHEN nilai_nilai.id_matkul = '$id_matkul' THEN nilai_nilai.nilai_akhir END) AS nilai_akhir
                FROM
                    nilai_nilai
                INNER JOIN mahasiswa ON mahasiswa.NPM = nilai_nilai.NPM
                INNER JOIN mata_kuliah ON mata_kuliah.id_matkul = nilai_nilai.id_matkul
                INNER JOIN detail_nilai ON detail_nilai.id_nilai = nilai_nilai.id_nilai
                WHERE
                    nilai_nilai.id_matkul = '$id_matkul'
                GROUP BY
                    nilai_nilai.NPM, mahasiswa.nama_mahasiswa, mahasiswa.kelas, detail_nilai.nilai_tugas, detail_nilai.nilai_uts, detail_nilai.nilai_uas;";
        return $this->db->query($sql)->getResultArray();
    }
}
