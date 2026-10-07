<?php
// app/controllers/TagController.php - Controller Manajemen Master Tags (Many-to-Many)

require_once __DIR__ . '/../models/Tag.php';

class TagController extends Controller {
    public function index() {
        $data['judul'] = 'Kelola Master Tags (Many-to-Many)';
        $tags = Tag::all();

        // Ambil produk yang terhubung untuk setiap tag
        foreach ($tags as &$t) {
            $t['products'] = Tag::products($t['id']);
            $t['total_products'] = count($t['products']);
        }
        unset($t);

        $data['tags'] = $tags;

        $this->view('templates/header', $data);
        $this->view('tag/index', $data);
        $this->view('templates/footer');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validateToken()) {
                Session::flash('danger', 'Token CSRF tidak valid!');
                return redirect('tag');
            }

            // Validasi request input ala Laravel
            $validated = $this->validate([
                'nama_tag' => 'required|min:2|max:50'
            ], $_POST, 'tag');

            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $validated['nama_tag']));
            Tag::create([
                'nama_tag' => $validated['nama_tag'],
                'slug'     => $slug
            ]);

            Session::flash('success', 'Tag berhasil ditambahkan!');
            return redirect('tag');
        }
    }

    public function delete($id = null) {
        if ($id && Tag::delete($id) > 0) {
            Session::flash('success', 'Tag berhasil dihapus!');
        } else {
            Session::flash('danger', 'Gagal menghapus tag!');
        }
        return redirect('tag');
    }
}
