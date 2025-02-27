<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NilaiNilaiModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class NilaiNilaiApiController extends BaseController
{
    use ResponseTrait;
    protected $m_nilainilai;

    public function __construct()
    {
        $this->m_nilainilai = new NilaiNilaiModel();
    }

    public function index()
    {
        // get all NilaiNilai
        $res =[
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_nilainilai->orderBy("id_nilai", "ASC")->findAll()
        ];
        return $this->respond($res);
    }

        // get NilaiNilai by id_nilai
    public function show($id_nilai)
    {
        $data = $this->m_nilainilai->find($id_nilai);
        
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }
    }

    public function create()
    {
        $data = [
            "id_dosen" => $this->request->getPost("id_dosen"),
            "id_matkul" => $this->request->getPost("id_matkul"),
            "NPM" => $this->request->getPost("NPM")
        ];
        $this->m_nilainilai->insert($data);

        $res = [
            "status" => 201,
            "message" => "Nilai berhasil dibuat!",
            "data" => $data
        ];
        return $this->respond($res);
    }

    public function update($id_nilai)
    {
        $id_data = $this->m_nilainilai->find($id_nilai);
        
        if ($id_data) {
            $data = $this->request->getRawInput();
            $this->m_nilainilai->update($id_nilai, $data);
            $res = [
                "status" => 201,
                "message" => "Data berhasil di update",
                "data" => $data
            ];
            return $this->respond($res);
        } else {
            return $this->failNotFound('id nilai tidak ditemukan!');

        }
    }
    
    public function delete($id_nilai)
    {
        $data = $this->m_nilainilai->find($id_nilai);

        if ($data) {
            $this->m_nilainilai->delete($id_nilai);
            return $this->respondDeleted(['status' => 203, 'message' => 'ID nilai berhasil dihapus.']);
        } else {
            return $this->failNotFound("Nilai dengan ID $id_nilai tidak ditemukan.");
        }
    }

    public function gets($id_matkul)
    {
        //
        $res = [
            "status" => 200,
            "message" => "Data berhasil di ambil!",
            "data" => $this->m_nilainilai->vw_dosen($id_matkul)
       ];
       return $this->respond($res);
    }
}
