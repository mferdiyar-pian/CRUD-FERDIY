<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Tampilkan semua post (halaman home)
    public function index()
    {
        $posts = Post::all();
        return view('home', compact('posts'));
    }

    // Simpan post baru
    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string'
        ]);

        Post::create([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        return redirect()->route('home')->with('success', 'Post berhasil ditambahkan!');
    }

    // Tampilkan form edit post
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('edit-post', compact('post'));
    }

    // Update data post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string'
        ]);

        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'body'  => $request->body,
        ]);

        return redirect()->route('home')->with('success', 'Post berhasil diperbarui!');
    }

    // Hapus post
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('home')->with('success', 'Post berhasil dihapus!');
    }
}
