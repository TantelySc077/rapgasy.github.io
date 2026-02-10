<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\File;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Créer un utilisateur client
        $client = User::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Client',
                'password' => bcrypt('password'),
                'role' => 'client',
            ]
        );

        // Créer le dossier de stockage s'il n'existe pas
        $albumsDir = storage_path('app/public/albums');
        if (!File::exists($albumsDir)) {
            File::makeDirectory($albumsDir, 0755, true);
        }

        // Albums de test avec tes images
        $albums = [
            [
                'artist_name' => 'VoayGang',
                'title' => 'Manga',
                'price' => 10000,
                'description' => 'Album Manga - Une aventure musicale épique',
                'image_file' => 'album_1.jpg',
                'tracks' => [
                    ['title' => 'Manga Intro', 'duration' => 180],
                    ['title' => 'Voyage Tsara', 'duration' => 215],
                    ['title' => 'Sakavo Mivaika', 'duration' => 205],
                    ['title' => 'Fandrosoana Ny', 'duration' => 210],
                    ['title' => 'Voninahitra Liana', 'duration' => 200],
                    ['title' => 'Manga Outro', 'duration' => 185],
                ]
            ],
            [
                'artist_name' => 'KEMYRAH',
                'title' => 'Lanitra Manga',
                'price' => 10000,
                'description' => 'Deuxième album merveilleux',
                'image_file' => 'album_2.jpg',
                'tracks' => [
                    ['title' => 'Ny Lanitra', 'duration' => 190],
                    ['title' => 'Manga Tsara', 'duration' => 210],
                    ['title' => 'Sakaiza Feo', 'duration' => 175],
                    ['title' => 'Voninahitra', 'duration' => 195],
                ]
            ],
            [
                'artist_name' => 'RNDR',
                'title' => 'Primatik',
                'price' => 10000,
                'description' => 'Album Primatik - Une expérience musicale unique',
                'image_file' => 'album_3.jpg',
                'tracks' => [
                    ['title' => 'Intro Primatik', 'duration' => 180],
                    ['title' => 'Ny Azo', 'duration' => 215],
                    ['title' => 'Fanahy Mainty', 'duration' => 200],
                    ['title' => 'Sakavo', 'duration' => 195],
                    ['title' => 'Lanirina', 'duration' => 210],
                    ['title' => 'Fahasamihafana', 'duration' => 205],
                    ['title' => 'Volo Mikatona', 'duration' => 190],
                    ['title' => 'Tsy Mahay Mahita', 'duration' => 225],
                    ['title' => 'Fitsarana Sitraka', 'duration' => 200],
                    ['title' => 'Ady Mandroso', 'duration' => 215],
                    ['title' => 'Soa Sy Ratsy', 'duration' => 205],
                    ['title' => 'Hira Misiva', 'duration' => 210],
                    ['title' => 'Outro Primatik', 'duration' => 185],
                ]
            ],
            [
                'artist_name' => 'RNDR',
                'title' => 'MEX',
                'price' => 10000,
                'description' => 'Album MEX - 22 morceaux d\'une expérience musicale intense',
                'image_file' => 'album_4.jpg',
                'tracks' => [
                    ['title' => 'MEX Intro', 'duration' => 180],
                    ['title' => 'Metsika 1', 'duration' => 210],
                    ['title' => 'Fitsarana', 'duration' => 205],
                    ['title' => 'Ranomasina', 'duration' => 215],
                    ['title' => 'Voninahitra Mainty', 'duration' => 200],
                    ['title' => 'Ady Tsara', 'duration' => 195],
                    ['title' => 'Sakavo Maitso', 'duration' => 210],
                    ['title' => 'Lanitra Manga', 'duration' => 205],
                    ['title' => 'Fahasamihafana', 'duration' => 220],
                    ['title' => 'Ny Azo Mahita', 'duration' => 215],
                    ['title' => 'Hira Mivaika', 'duration' => 210],
                    ['title' => 'Lanirina Tsi', 'duration' => 200],
                    ['title' => 'MEX 13', 'duration' => 225],
                    ['title' => 'Fitsarana Sitraka', 'duration' => 210],
                    ['title' => 'Ady Mandroso', 'duration' => 215],
                    ['title' => 'Sakavo Ravelon', 'duration' => 205],
                    ['title' => 'Ny Teeny Malama', 'duration' => 220],
                    ['title' => 'Fanahy Miavaka', 'duration' => 210],
                    ['title' => 'Voninahitra Folaka', 'duration' => 215],
                    ['title' => 'Tsy Mahay Miala', 'duration' => 205],
                    ['title' => 'MEX Bridge', 'duration' => 230],
                    ['title' => 'MEX Outro', 'duration' => 185],
                ]
            ],
            [
                'artist_name' => 'Louckim',
                'title' => 'Blazing',
                'price' => 10000,
                'description' => 'Album Blazing - Une explosion de rythmes et d\'énergie',
                'image_file' => 'album_5.jpg',
                'tracks' => [
                    ['title' => 'Blazing Intro', 'duration' => 180],
                    ['title' => 'Feu de Vie', 'duration' => 215],
                    ['title' => 'Sakavo Mirehitra', 'duration' => 205],
                    ['title' => 'Ady Mivaika', 'duration' => 220],
                    ['title' => 'Lanirina Hot', 'duration' => 210],
                    ['title' => 'Voninahitra Milenesa', 'duration' => 215],
                    ['title' => 'Hira Mizotra', 'duration' => 200],
                    ['title' => 'Tsy Mahay Miala', 'duration' => 225],
                    ['title' => 'Blazing Bridge', 'duration' => 230],
                    ['title' => 'Blazing Outro', 'duration' => 185],
                ]
            ],
            [
                'artist_name' => 'Nanté98',
                'title' => 'Lior',
                'price' => 10000,
                'description' => 'Album Lior - Une expérience musicale lumineuse',
                'image_file' => 'album_6.jpg',
                'tracks' => [
                    ['title' => 'Lior Intro', 'duration' => 180],
                    ['title' => 'Miavaka', 'duration' => 215],
                    ['title' => 'Sakavo Fanampiny', 'duration' => 205],
                    ['title' => 'Voninahitra Tsy', 'duration' => 220],
                    ['title' => 'Ny Azo Lior', 'duration' => 210],
                    ['title' => 'Fitsarana Miavaka', 'duration' => 215],
                    ['title' => 'Hira Lioray', 'duration' => 200],
                    ['title' => 'Lior Bridge', 'duration' => 235],
                    ['title' => 'Lior Outro', 'duration' => 185],
                ]
            ],
            [
                'artist_name' => 'ZAZA RAP TAIZA',
                'title' => 'TSY HO BADO',
                'price' => 10000,
                'description' => 'Compilation TSY HO BADO (2025), produit par KM, pour la promotion de l\'éducation pour tous à Madagascar',
                'image_file' => 'zaza_cover.jpg',
                'tracks' => [
                    ['title' => 'Intro - TSY HO BADO', 'duration' => 180],
                    ['title' => 'Fahitana', 'duration' => 215],
                    ['title' => 'Ireo Fampanajana', 'duration' => 200],
                    ['title' => 'Fandrosoana', 'duration' => 190],
                    ['title' => 'Afovoany', 'duration' => 210],
                    ['title' => 'Toerana', 'duration' => 195],
                    ['title' => 'Fanohizana', 'duration' => 205],
                ]
            ],
        ];

        foreach ($albums as $albumData) {
            $tracks = $albumData['tracks'];
            $imageFile = $albumData['image_file'] ?? null;
            unset($albumData['tracks']);
            if (isset($albumData['color'])) {
                unset($albumData['color']);
            }
            unset($albumData['image_file']);

            // Utiliser l'image fournie ou créer une image SVG
            $coverImage = $imageFile ? 'albums/' . $imageFile : $this->createAlbumImage($albumsDir, $albumData['title'], '#FF6B6B');

            $album = Album::create([
                ...$albumData,
                'user_id' => $admin->id,
                'cover_image' => $coverImage,
            ]);

            foreach ($tracks as $track) {
                Track::create([
                    ...$track,
                    'file_path' => 'audio/dummy.mp3',
                    'album_id' => $album->id,
                ]);
            }
        }
    }

    /**
     * Créer une image SVG pour un album
     */
    private function createAlbumImage($directory, $title, $color)
    {
        $filename = 'album_' . time() . '_' . uniqid() . '.svg';
        $filepath = $directory . '/' . $filename;

        // Créer une image SVG colorée avec le titre
        $svg = <<<SVG
<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
  <rect width="200" height="200" fill="$color"/>
  <circle cx="100" cy="100" r="50" fill="white" opacity="0.2"/>
  <circle cx="100" cy="100" r="30" fill="white" opacity="0.3"/>
  <text x="100" y="110" font-size="16" font-weight="bold" text-anchor="middle" fill="white" opacity="0.9">
    🎵
  </text>
  <text x="100" y="180" font-size="12" text-anchor="middle" fill="white" opacity="0.8" font-weight="bold">
    {$title}
  </text>
</svg>
SVG;

        File::put($filepath, $svg);
        return 'albums/' . $filename;
    }
}
