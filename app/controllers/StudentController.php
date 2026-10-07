<?php
// app/controllers/StudentController.php - Controller Manajemen Data Siswa / Student

require_once __DIR__ . '/../models/Student.php';

class StudentController extends Controller {
    public function index() {
        $data['judul'] = 'Daftar Siswa (Tabel Student)';
        $data['students'] = Student::all();

        $this->view('templates/header', $data);
        $this->view('student/index', $data);
        $this->view('templates/footer');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validateToken()) {
                Session::flash('danger', 'Token CSRF tidak valid!');
                return redirect('student');
            }

            // Validasi request input ala Laravel
            $validated = $this->validate([
                'nama'     => 'required|min:3|max:100',
                'kategori' => 'required|string',
                'harga'    => 'required|numeric|min:0',
                'stok'     => 'required|integer|min:0'
            ], $_POST, 'student');

            Student::create($validated);
            Session::flash('success', 'Data siswa berhasil ditambahkan!');
            return redirect('student');
        }
    }

    public function delete($id = null) {
        if ($id && Student::delete($id) > 0) {
            Session::flash('success', 'Data siswa berhasil dihapus!');
        } else {
            Session::flash('danger', 'Gagal menghapus data siswa!');
        }
        return redirect('student');
    }
}
