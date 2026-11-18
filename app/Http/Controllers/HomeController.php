<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $siteName = 'KursusKu';

        $featured = [
            [
                'code' => 'WEB-01',
                'name' => 'Web Development',
                'description' => 'Mempelajari dasar HTML, CSS, JavaScript hingga pengembangan aplikasi web modern yang interaktif dan responsif.'
            ],
            [
                'code' => 'DSG-02',
                'name' => 'Desain Grafis',
                'description' => 'Menguasai prinsip desain visual, tata letak, tipografi, dan komposisi grafis profesional untuk berbagai media.'
            ],
            [
                'code' => 'DMK-03',
                'name' => 'Digital Marketing',
                'description' => 'Strategi pemasaran digital, optimasi mesin pencari (SEO), media sosial, dan analisis efektivitas kampanye promosi.'
            ],
            [
                'code' => 'UIX-04',
                'name' => 'UI/UX Design',
                'description' => 'Perancangan antarmuka pengguna digital, riset pengguna, pembuatan wireframe, prototyping, dan usability testing.'
            ],
            [
                'code' => 'DAT-05',
                'name' => 'Data Analysis',
                'description' => 'Eksplorasi data, pengolahan statistik dasar, visualisasi data, dan penarikan wawasan untuk pengambilan keputusan.'
            ],
            [
                'code' => 'OFF-06',
                'name' => 'Microsoft Office',
                'description' => 'Optimalisasi perangkat lunak perkantoran untuk pengolahan dokumen, analisis spreadsheet, dan presentasi kerja.'
            ],
        ];

        return view('home', compact('siteName', 'featured'));
    }
}
