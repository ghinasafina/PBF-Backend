<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class DosenApiController extends BaseController
{
    use ResponseTrait;
    protected $m_dosen;

    public function __construct()
    {
        $this->m_dosen = new DosenModel();
    }

    public function index()
    {
        //
        $res = [
            "status" => 200,
            "message" => "Data berhasil dimuat!",
            "data" => $this->m_dosen->orderBy("id_dosen", "ASC")->findAll()
        ];

        return $this->respond($res);
    }

    public function show($id_dosen)
    {
        //
        $data = $this->m_dosen->find($id_dosen);
        
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id_dosen tidak ditemukan.");
        }
    }
    
    public function create()
    {
        $data = [
            "id_dosen" => $this->request->getPost("id_dosen"),
            "nama_dosen" => $this->request->getPost("nama_dosen"),
            "email" => $this->request->getPost("email"),
            "no_telp" => $this->request->getPost("no_telp")
        ];
        $this->m_dosen->insert($data);

        $res = [
            "status" => 201,
            "message" => "Data dosen berhasil dibuat!",
            "data" => $data
        ];
        return $this->respond($res);
    }

    // Update mahasiswa by id_dosen
    public function update($id_dosen)
    {
        $data = $this->request->getRawInput();

        if ($this->m_dosen->update($id_dosen, $data)) {
            return $this->respond(['message' => 'Data dosen berhasil diupdate.']);
        } else {
            return $this->failValidationErrors($this->m_dosen->errors());
        }
    }

    public function delete($id_dosen)
    {
        $data = $this->m_dosen->find($id_dosen);

        if ($data) {
            $this->m_dosen->delete($id_dosen);
            return $this->respondDeleted(['status' => 203, 'message' => 'Data dosen berhasil dihapus.']);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id_dosen tidak ditemukan.");
        }
    }
}