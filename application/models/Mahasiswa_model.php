<?php

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model
{


    private $_client;

    public function __construct()
    {
        $this->_client = new Client([
            'base_uri' => 'http://localhost/rest-api/rest-server/api/',
            'auth' => ['admin', '1234']
        ]);
    }

    public function getAllMahasiswa()
    {
        // $client = new Client();

        $resposnse = $this->_client->request('GET', 'Mahasiswa', [
            // 'auth' => ['admin','1234'],
            'query' => [
                'mahasiswa_key' => 'user123'
            ]
        ]);

        $result = json_decode($resposnse->getBody()->getContents(), true);

        return $result['data'];
    }

    public function getMahasiswaById($id)
    {
        // $client = new Client();

        $resposnse = $this->_client->request('GET', 'Mahasiswa', [
            // 'auth' => ['admin','1234'],
            'query' => [
                'mahasiswa_key' => 'user123',
                'id' => $id
            ]
        ]);

        $result = json_decode($resposnse->getBody()->getContents(), true);

        return $result['data'][0];
    }

    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            'mahasiswa_key' => 'user123'
        ];

        $respose = $this->_client->request('POST','Mahasiswa', [
            'form_params' => $data
            
        ]);
        $result = json_decode($respose->getBody()->getContents(), true);
        return $result;
    }

    public function hapusDataMahasiswa($id)
    {
        $respose = $this->_client->request('DELETE', 'Mahasiswa', [
            'form_params' => [
                'id' => $id,
                'mahasiswa_key' => 'user123'
            ]
        ]);
        $result = json_decode($respose->getBody()->getContents(), true);
        return $result;
    }



    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true),
            "id" => $this->input->post('id', true),
            'mahasiswa_key' => 'user123'
        ];

        $respose = $this->_client->request('PUT','Mahasiswa', [
            'form_params' => $data
            
        ]);
        $result = json_decode($respose->getBody()->getContents(), true);
        return $result;
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}
