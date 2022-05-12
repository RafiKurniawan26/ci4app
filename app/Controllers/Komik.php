<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    // ################################################################################################
    public function index()
    {
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        // cara konek db tanpa model
        // $db = \Config\Database::connect();
        // $komik = $db->query('SELECT * FROM komik');
        // foreach ($komik->getResultArray() as $k) {
        //     d($k);
        // }

        return view('komik/index', $data);
    }


    // ################################################################################################
    public function detail($id)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($id)
        ];
        // jika komik tidak ada di tabel komik
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $id . ' tidak ditemukan');
        }


        return view('komik/detail', $data);
    }


    // ################################################################################################
    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah Data Komik',
            'validation' => \Config\Services::validation()

        ];

        return view('komik/create', $data);
    }


    // ################################################################################################
    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah ada.'
                ]
            ]
        ])) {
            $validation  = \Config\Services::validation();
            return redirect()->to('komik/create')->withInput()->with('validation', $validation);
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data Komik berhasil ditambahkan');

        return redirect()->to('/komik');
    }


    // ################################################################################################
    public function delete($id)
    {
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data Komik berhasil dihapus');
        return redirect()->to('/komik');
    }


    // ################################################################################################
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Komik',
            'komik' => $this->komikModel->getKomik($id),
            'validation' => \Config\Services::validation()
        ];

        return view('komik/edit', $data);
    }

    // ################################################################################################
    public function update($id_slug)
    {
        // validasi input
        $komikLama = $this->komikModel->getKomik($this->request->getVar('id'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi.',
                    'is_unique' => '{field} komik sudah ada.'
                ]
            ]
        ])) {
            $validation  = \Config\Services::validation();
            return redirect()->to('komik/edit' . $this->request->getVar('id'))->withInput()->with('validation', $validation);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id_slug,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'Data Komik berhasil diubah');

        return redirect()->to('/komik');
    }
}
