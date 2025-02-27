<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DetailNilaiModel;
use CodeIgniter\API\ResponseTrait;

class DetailNilaiApiController extends BaseController
{
    use ResponseTrait;
    protected $m_nilai;

    public function __construct()
    {
        $this->m_nilai = new DetailNilaiModel();
    }

    // Get all nilai
    public function index()
    {
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_nilai->orderBy("id_detail", "ASC")->findAll()
        ];
        return $this->respond($res);
    }

    // Get nilai by id_detail
    public function show($id_detail)
    {
        $model = new DetailNilaiModel();
        $data = $model->find($id_detail);

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("Nilai dengan ID $id_detail tidak ditemukan.");
        }
    }

    // Create new nilai
    public function create()
    {
        $data = [
            "id_nilai" => $this->request->getPost("id_nilai"),
            "nilai_tugas" => $this->request->getPost("nilai_tugas"),
            "nilai_uts" => $this->request->getPost("nilai_uts"),
            "nilai_uas" => $this->request->getPost("nilai_uas"),
        ];
        $this->m_nilai->insert($data);

        $res = [
            "status" => 201,
            "message" => "Nilai berhasil dibuat!",
            "data" => $data
        ];
        return $this->respond($res);
    }

    // Update nilai by id_nilai
    public function update($id_nilai)
    {
        $model = new DetailNilaiModel();
        $data = $this->request->getRawInput();

        if ($model->update($id_nilai, $data)) {
            return $this->respond(['message' => 'Nilai berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($model->errors());
        }
    }

    // Delete nilai by id_nilai
    public function delete($id_nilai)
    {
        $model = new DetailNilaiModel();
        $data = $model->find($id_nilai);

        if ($data) {
            $model->delete($id_nilai);
            return $this->respondDeleted(['message' => 'Nilai berhasil dihapus.']);
        } else {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }
    }
}