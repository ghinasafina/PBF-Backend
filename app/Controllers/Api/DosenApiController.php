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
        // fungsi untuk menyimpan data ke tabel dosen
        try {
            $rules = [
                'nama_dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'nama dosen harus di isi!'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'email harus di isi!',
                        'valid_email' => 'email tidak valid'
                    ]
                ],
                'no_telp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'no telp harus di isi!'
                    ]
                ]
            ];
            
            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }
    
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
            
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }    

    // Update dosen by id_dosen
    public function update($id_dosen)
    {
        try {
            $rules = [
                'nama_dosen' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama dosen harus diisi!'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email harus diisi!',
                        'valid_email' => 'Email tidak valid'
                    ]
                ],
                'no_telp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'No telepon harus diisi!'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors());
            }

            $data = [
                'nama_dosen' => $this->request->getRawInput()['nama_dosen'] ?? null,
                'email' => $this->request->getRawInput()['email'] ?? null,
                'no_telp' => $this->request->getRawInput()['no_telp'] ?? null
            ];

            if ($this->m_dosen->update($id_dosen, $data)) {
                return $this->respond(['message' => 'Data dosen berhasil diupdate.']);
            } else {
                return $this->failValidationErrors($this->m_dosen->errors());
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
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