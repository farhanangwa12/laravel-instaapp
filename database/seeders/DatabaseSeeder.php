<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 3 user
        $user1 = User::create([
            'name' => 'Andi Saputra',
            'email' => 'andi.saputra@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password123'),
        ]);

        $user3 = User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Membuat 3 post
        $post1 = Post::create([
            'user_id' => $user1->id,
            'content' => 'Bersama sahabat-sahabat terbaik dari dunia masa depan! Doraemon, Nobita, Shizuka, Gian, dan Suneo selalu hadir dengan petualangan seru, tawa, dan persahabatan yang tak terlupakan.',
            'image' => 'images/7z3YutJdKKHQiWdBkvUDN1zB6Inp5aZMFtBwAfA1.png'
        ]);

        $post2 = Post::create([
            'user_id' => $user2->id,
            'content' => '⛓️ Terjebak di antara ilusi dan realita. Garis-garis ini bukan sekadar pola, tapi labirin visual yang menguji mata dan pikiran. Berani menatap lebih lama?',
            'image' => 'images/cDUsafkxSXucfwvCRUV9W1iI5AecuFNLI3JLMWO5.jpg'

        ]);

        $post3 = Post::create([
            'user_id' => $user3->id,
            'content' => '📸 Ketika dunia nyata bertemu dunia kartun! Doraemon dan Nobita hadir dalam ukuran raksasa, bukan lagi di layar tapi langsung di depan mata. Childhood vibes, nostalgia level maksimal!',
            'image' => 'images/sbhlRGmqoTnAAxs8mmE226nS2z1b6DymkSSh5CTd.jpg'

        ]);

        // Post 1: 3 like, 2 comment
        Like::create(['user_id' => $user1->id, 'post_id' => $post1->id]);
        Like::create(['user_id' => $user2->id, 'post_id' => $post1->id]);
        Like::create(['user_id' => $user3->id, 'post_id' => $post1->id]);

        Comment::create([
            'user_id' => $user2->id,
            'post_id' => $post1->id,
            'content' => 'Selalu seru lihat geng Doraemon lengkap begini, nostalgia banget!',
        ]);

        Comment::create([
            'user_id' => $user3->id,
            'post_id' => $post1->id,
            'content' => 'Masa kecil nggak lengkap tanpa nonton petualangan mereka tiap sore!',
        ]);


        // Post 2: 1 like, 1 comment
        Like::create(['user_id' => $user1->id, 'post_id' => $post2->id]);

        Comment::create([
            'user_id' => $user3->id,
            'post_id' => $post2->id,
            'content' => 'Sekilas sederhana, tapi makin lama dilihat bikin pusing juga ya! Ilusi optik memang selalu menarik.',
        ]);


        Comment::create([
            'user_id' => $user1->id,
            'post_id' => $post3->id,
            'content' => 'Doraemon dan Nobita versi patungnya lucu banget, kayak hidup beneran!',
        ]);

        Comment::create([
            'user_id' => $user2->id,
            'post_id' => $post3->id,
            'content' => 'Berasa jalan-jalan ke dunia kartun, spot foto wajib buat penggemar Doraemon.',
        ]);
    }
}
