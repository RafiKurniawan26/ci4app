<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Me',
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                'tipe' => 'rumah',
                'alamat' => 'Jl. Raya Cisarua',
                'kota' => 'Cisarua',
            ],
            [
                'tipe' => 'kantor',
                'alamat' => 'Jl. Setia Budi No.193',
                'Kota' => 'Bandung'
            ],
        ];
        return view('pages/contact', $data);
    }
}
