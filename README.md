Saya sedang membangun aplikasi Laravel bernama "Sistem Pelanggaran dan Poin Tata Tertib" untuk SMK Negeri 1 Kota Bekasi. Ini web app berbasis Blade (bukan REST API), autentikasi pakai session bawaan Laravel.

KONTEKS SISTEM:
Aplikasi ini mencatat pelanggaran dan apresiasi siswa. Ada 3 peran pengguna dengan model User custom (bukan tabel `users` bawaan Laravel):
- Kepala Sekolah (role: "Kepala sekolah") = Super Admin — lihat semua data, kelola akun admin, beri apresiasi siswa
- Wali Kelas & Kesiswaan (role: "Wali kelas" / "Kesiswaan") = Admin — kelola data siswa, input laporan pelanggaran
- BK (role: "BK") — lihat semua data pelanggaran, lakukan pembinaan/konseling, buat rekap laporan bulanan

MODEL YANG SUDAH ADA (jangan dibuat ulang, cukup dipakai):
- App\Models\User — tabel `user`, primary key `id_user`, kolom: username, nama, password, role (enum: 'Kepala sekolah', 'Wali kelas', 'BK', 'Kesiswaan')
- App\Models\Kelas — tabel `kelas`, primary key `id_kelas`
- App\Models\Siswa — tabel `siswa`, primary key `id_siswa`, kolom: id_kelas (FK), nis, nama, total_point
- App\Models\JenisPelanggaran — tabel `jenis_pelanggaran`, primary key `id_jenis`, kolom: nama_pelanggaran, tingkat, point

MODEL YANG PERLU DIBUATKAN CONTROLLER-NYA (model Eloquent-nya sudah ada, tinggal dibuatkan Controller):

1. App\Models\Pelanggaran — tabel `pelanggaran`, primary key `id_pelanggaran`
   Kolom: id_user (FK ke user, pelapor), id_siswa (FK ke siswa), tanggal, lokasi, status, id_jenis (FK ke jenis_pelanggaran), poin (snapshot poin saat kejadian, integer), waktu_kejadian (time, nullable), kronologi (text, nullable)
   Relasi: belongsTo Siswa, belongsTo JenisPelanggaran, belongsTo User (sebagai pelapor), hasMany BuktiPelanggaran, hasMany TindakLanjut

2. App\Models\BuktiPelanggaran — tabel `bukti_pelanggaran`, primary key `id_bukti`
   Kolom: id_pelanggaran (FK), jenis_bukti (enum: 'foto','video','catatan_saksi','lainnya'), file_path (nullable), keterangan (nullable)
   Relasi: belongsTo Pelanggaran

3. App\Models\TindakLanjut — tabel `tindak_lanjut`, primary key `id_tindaklanjut`
   Kolom: id_pelanggaran (FK), id_user (FK, yang menangani), tanggal, jenis_tindakan, hasil
   Relasi: belongsTo Pelanggaran, belongsTo User

4. App\Models\Konseling — tabel `konseling`, primary key `id_konseling`
5. App\Models\SesiKonseling — tabel `sesi_konseling`, primary key `id_sesi_konseling`
   Kolom: id_konseling (FK), id_siswa (FK), tanggal, permasalahan, id_user (FK, BK yang menangani), solusi (nullable), hasil (nullable)
   Relasi: belongsTo Konseling, belongsTo Siswa, belongsTo User

BUSINESS LOGIC YANG WAJIB DIIMPLEMENTASIKAN:

1. Saat PelanggaranController@store berhasil menyimpan data baru:
   - Ambil nilai `point` dari JenisPelanggaran yang dipilih, simpan sebagai snapshot ke kolom `poin` di Pelanggaran (jangan reference langsung ke jenis_pelanggaran.point di masa depan)
   - Tambahkan nilai poin tersebut ke `total_point` milik Siswa terkait
   - Bungkus proses simpan pelanggaran + update total_point siswa dalam satu DB transaction (DB::transaction)

2. Role-based access:
   - Hanya user dengan role "Wali kelas" atau "Kesiswaan" yang boleh input pelanggaran baru (store/create)
   - Role "BK" hanya boleh melihat data pelanggaran (index/show), tidak boleh create/edit/delete pelanggaran, tapi boleh create/edit TindakLanjut dan Konseling/SesiKonseling
   - Role "Kepala sekolah" hanya boleh melihat (read-only) semua data di atas
   - Gunakan middleware atau otorisasi berbasis role (boleh pakai Gate/Policy atau pengecekan role langsung, sesuaikan yang paling sederhana untuk skala proyek ini)

TUGAS:
Buatkan Controller berikut dengan method resource standar (index, create, store, show, edit, update, destroy) sesuai aturan akses di atas, beserta validasi request untuk setiap store/update (pakai `$request->validate()` langsung di controller, tidak perlu Form Request class terpisah dulu):
1. PelanggaranController (termasuk logic akumulasi poin di atas)
2. BuktiPelanggaranController (untuk tambah/hapus lampiran bukti per pelanggaran; boleh berupa nested resource dari Pelanggaran)
3. TindakLanjutController
4. KonselingController dan SesiKonselingController

Untuk setiap controller, tampilkan juga contoh route resource-nya yang perlu didaftarkan di routes/web.php (dikelompokkan pakai middleware auth + pengecekan role).