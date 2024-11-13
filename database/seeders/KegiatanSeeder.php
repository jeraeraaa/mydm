<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('kegiatan')->insert([
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => "Dharmayana's Welcoming Party (DWP)",
                'deskripsi_kegiatan' => 'Program kerja yang bertujuan menyambut mahasiswa/i baru buddhis Universitas Tarumanagara.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Darmadhista (DD)',
                'deskripsi_kegiatan' => 'Program kerja yang dilakukan dengan melalukan makrab dari Dharmayana dengan tujuan untuk mempererat persaudaraan dan dapat mengenal satu sama lain di dalam Dharmayana.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Pindapata dan Sangha Dana di Bulan Kathina',
                'deskripsi_kegiatan' => 'Program kerja yang memiliki tujuan untuk memperingati salah satu hari besar agama Buddha dengan berbagai rangkaian acara yang telah disiapkan.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Latihan Kepemimpinan (LK)',
                'deskripsi_kegiatan' => 'Program kerja yang bertujuan untuk menumbuhkan rasa kepemimpinan anggota Dharmayana.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Pekan Penghayatan Dhamma (PPD)',
                'deskripsi_kegiatan' => 'Program kerja yang bertujuan untuk melatih dan mengajarkan anggota Dharmayana dalam menjalankan sila dalam buddhis serta memperdalam pengetahuan buddhis.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Metta Day (MD)',
                'deskripsi_kegiatan' => 'Program kerja yang mengadakan atau memberikan bantuan kepada masyarakat, berupa balai kesehatan yang beranekaragama dan donasi ke berbagai sekolah.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Buddhist Camp (BC)',
                'deskripsi_kegiatan' => 'Program kerja yang mengadakan camping dengan tujuan meningkatkan jiwa petualang anggota Dharmayana.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Dharmayana Buddhist Festival (DBF)',
                'deskripsi_kegiatan' => 'Program kerja yang memiliki tujuan merayakan hari raya Waisak sekaligus ulang tahun Dharmayana dan Berita Dharmayana.'
            ],
            [
                'id_kategori_kegiatan' => 2,
                'nama_kegiatan' => 'Berita Dharmayana (BD)',
                'deskripsi_kegiatan' => 'Program kerja yang memberikan dan mengajarkan informasi mengenai kebajikan dengan membuat dan menerbitkan majalah budhis.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'Kebaktian Humas',
                'deskripsi_kegiatan' => 'Kebaktian yang dilaksanakan oleh Divisi Humas dengan mengunjungi vihara-vihara se-Jabodetabek setiap minggunya.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'Volunteer',
                'deskripsi_kegiatan' => 'Volunteer terhadap kegiatan-kegiatan eksternal yang dikelola oleh Divisi Humas.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'Kebaktian Bakti',
                'deskripsi_kegiatan' => 'Kebaktian yang diselenggarakan oleh Divisi Bakti.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'Chanting',
                'deskripsi_kegiatan' => 'Pembacaan paritta yang diselenggarakan Divisi Bakti.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'Dhamma Class',
                'deskripsi_kegiatan' => 'Kelas Dhamma yang dilaksanakan BPH untuk menambah pengetahuan akan buddhisme.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'DM Sport',
                'deskripsi_kegiatan' => 'Kegiatan olahraga yang mengasyikan dilaksanakan oleh Divisi Bakat dan Minat untuk mengakrabkan anggota Dharmayana. Contohnya seperti badminton, basket, billiard, dll.'
            ],
            [
                'id_kategori_kegiatan' => 1,
                'nama_kegiatan' => 'DM E-Sport',
                'deskripsi_kegiatan' => 'Kegiatan bermain secara online yang dilaksanakan oleh Divisi Bakat dan Minat untuk mengakrabkan anggota Dharmayana. Contohnya seperti Among Us, Mobile Legend.'
            ],
        ]);
    }
}
