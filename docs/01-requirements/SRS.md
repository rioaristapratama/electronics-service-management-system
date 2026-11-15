# SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

# Electronics Service Management System

**Versi:** 1.2  
**Status:** Final – Kebutuhan bisnis telah divalidasi  
**Jenis aplikasi:** Web-based Information System  
**Backend:** PHP – Laravel  
**Database:** MySQL  
**Frontend:** Blade + Bootstrap  
**Version Control:** Git & GitHub

---

# 1. PENDAHULUAN

## 1.1 Tujuan Proyek

Electronics Service Management System merupakan aplikasi berbasis web untuk membantu pengelolaan operasional usaha jasa perbaikan perangkat elektronik.

Aplikasi ini dirancang untuk mengelola data pelanggan, penerimaan perangkat, diagnosis kerusakan, estimasi biaya, persetujuan pelanggan, antrean pengerjaan, pembayaran, pengambilan perangkat, dan garansi.

Tujuan utamanya adalah menggantikan pencatatan yang sebelumnya dilakukan secara manual atau hanya berdasarkan ingatan dengan sistem digital yang terstruktur.

## 1.2 Ruang Lingkup

Sistem mencakup:

1. Autentikasi pengguna.
2. Pengelolaan pelanggan.
3. Pencatatan penerimaan servis.
4. Pengelolaan beberapa perangkat dalam satu catatan servis.
5. Diagnosis dan estimasi biaya.
6. Persetujuan pelanggan.
7. Pengelolaan antrean dan status pengerjaan.
8. Pencatatan kebutuhan komponen.
9. Pembayaran DP dan pelunasan.
10. Pengembalian DP apabila terjadi pembatalan.
11. Pengambilan sebagian atau seluruh perangkat.
12. Pemantauan masa garansi.
13. Pemantauan batas pengambilan tiga bulan.
14. Penyimpanan bukti pemberitahuan pelanggan.
15. Pembuatan nota digital.
16. Laporan transaksi dan riwayat servis.

## 1.3 Pengguna Sistem

Pengguna utama adalah pemilik atau pengelola usaha servis.

Pemilik usaha menjadi penanggung jawab utama atas seluruh perangkat yang diterima, meskipun pengerjaan dapat dilakukan oleh teknisi lain.

Pencatatan identitas teknisi dan pembagian hasil pekerjaan belum menjadi prioritas versi pertama.

---

# 2. ANALISIS PROSES BISNIS

## 2.1 Alur Penerimaan Perangkat

1. Pelanggan membawa satu atau beberapa perangkat.
2. Pengelola mencatat informasi pelanggan.
3. Pengelola mencatat perangkat yang diterima dalam satu catatan servis.
4. Informasi keluhan, merek, dan spesifikasi perangkat dicatat.
5. Kondisi fisik perangkat dapat dicatat sebagai informasi tambahan.
6. Sistem membuat nomor catatan servis secara otomatis.

Satu pelanggan yang membawa beberapa perangkat sekaligus mendapatkan satu nomor catatan servis.

Setiap perangkat dalam catatan tersebut tetap mempunyai informasi, biaya, dan status masing-masing.

## 2.2 Diagnosis dan Persetujuan

1. Teknisi memeriksa perangkat.
2. Teknisi mengidentifikasi kerusakan.
3. Teknisi menentukan estimasi biaya.
4. Informasi kerusakan, biaya, dan perkiraan waktu pengerjaan disampaikan melalui WhatsApp.
5. Pengelola mencatat pemberitahuan dan menyimpan bukti komunikasi.
6. Pelanggan memberikan keputusan.

Jika pelanggan menyetujui, perbaikan dapat dilanjutkan.

Jika pelanggan menolak:

- Perangkat dirapikan kembali.
- Perangkat dapat diambil pada hari yang sama.
- Tidak ada biaya pemeriksaan wajib.
- Pelanggan boleh memberikan pembayaran pemeriksaan secara sukarela.

## 2.3 Antrean Pengerjaan

Urutan penerimaan menjadi dasar antrean.

Pekerjaan dapat dilewati sementara apabila:

- Menunggu persetujuan pelanggan.
- Komponen belum tersedia.
- Terdapat kendala pengerjaan.

Pekerjaan yang tertunda dapat dilanjutkan setelah kendalanya selesai.

Pengerjaan normal diusahakan selesai pada hari yang sama. Jika antrean sedang banyak, jadwal dapat disesuaikan.

Jika komponen harus dipesan secara online, pengerjaan dapat memerlukan waktu hingga sekitar satu minggu, bergantung pada pengiriman.

## 2.4 Pembayaran dan Pengambilan

Setiap perangkat mempunyai biaya servis dan catatan pembayaran sendiri.

Pelanggan diperbolehkan:

- Mengambil perangkat yang sudah selesai tanpa menunggu perangkat lainnya.
- Membayar perangkat yang sudah selesai diambil.
- Membayar beberapa perangkat sekaligus.
- Menunggu semua perangkat selesai sebelum melakukan pembayaran sekaligus.

Pembayaran sekaligus diperbolehkan apabila teknisi telah mengetahui kerusakan dan biaya masing-masing perangkat.

Satu catatan servis tetap digunakan meskipun perangkat diambil pada waktu berbeda.

Setiap pembayaran harus memiliki alokasi yang jelas terhadap perangkat yang menjadi bagian dari pembayaran tersebut.

## 2.5 Penanggung Jawab Pekerjaan

Pemilik usaha bertanggung jawab penuh kepada pelanggan.

Pengerjaan dapat dilakukan oleh pemilik maupun teknisi lain sesuai kebutuhan. Nama teknisi dan pembagian hasil pekerjaan belum dicatat dalam versi pertama.

---

# 3. KATEGORI PERANGKAT

| Kategori | Jenis perangkat |
|---|---|
| TV & Display | LED TV, LCD TV, Smart TV, monitor, projector |
| Audio | Speaker, amplifier, radio, audio mixer, equalizer, crossover, subwoofer, wireless microphone, car audio |
| Home Appliances | Mesin cuci, kulkas, kipas angin, vacuum cleaner, dispenser, blender, mixer, juicer, exhaust fan, setrika listrik |
| Peralatan Dapur | Magic com / rice cooker |
| Kelistrikan & Power | Stabilizer, UPS, inverter, adapter, charger laptop, power supply |

TV tabung/CRT tidak termasuk perangkat yang diterima.

Informasi spesifikasi perangkat dibuat fleksibel sesuai jenis perangkat, misalnya ukuran layar, merek, model, atau kapasitas.

---

# 4. KEBUTUHAN FUNGSIONAL

## 4.1 Pengelolaan Pelanggan

Sistem harus dapat:

- Menambahkan data pelanggan.
- Menyimpan nama dan nomor telepon/WhatsApp.
- Menampilkan riwayat servis pelanggan.
- Menggunakan kembali data pelanggan yang sudah terdaftar.

## 4.2 Pengelolaan Catatan Servis

Sistem harus dapat:

- Membuat nomor servis secara otomatis.
- Mencatat tanggal penerimaan.
- Menghubungkan catatan servis dengan satu pelanggan.
- Menambahkan beberapa perangkat dalam satu catatan servis.
- Mencatat keluhan setiap perangkat.
- Mencatat merek dan spesifikasi perangkat.
- Menyediakan kolom opsional untuk kondisi fisik perangkat.

## 4.3 Diagnosis dan Estimasi Biaya

Sistem harus dapat:

- Mencatat hasil pemeriksaan.
- Mencatat kerusakan setiap perangkat.
- Mencatat komponen yang dibutuhkan.
- Menyimpan estimasi biaya per perangkat.
- Mencatat tanggal diagnosis.

## 4.4 Persetujuan Pelanggan

Sistem harus mencatat status:

- Menunggu persetujuan.
- Disetujui.
- Ditolak.

Jika pelanggan menolak perbaikan, sistem mencatat bahwa perangkat tidak dilanjutkan ke tahap perbaikan.

Pembayaran pemeriksaan bersifat sukarela dan tidak memiliki tarif wajib.

## 4.5 Pengelolaan Status Pengerjaan

Status setiap perangkat meliputi:

1. Baru masuk.
2. Pemeriksaan.
3. Menunggu persetujuan.
4. Menunggu komponen.
5. Siap dikerjakan.
6. Dalam pengerjaan.
7. Selesai diperbaiki.
8. Siap diambil.
9. Sudah diambil.
10. Ditolak pelanggan.

Status setiap perangkat dapat berubah secara independen meskipun berada dalam satu catatan servis.

Sistem harus menyimpan riwayat perubahan status agar perjalanan setiap perangkat dapat ditelusuri.

## 4.6 Pengelolaan Komponen

Sistem menyediakan pencatatan:

- Nama komponen.
- Perangkat yang membutuhkan komponen.
- Tanggal pemesanan.
- Perkiraan kedatangan.
- Status ketersediaan komponen.

Pengelolaan komponen dalam versi pertama hanya mencakup kebutuhan komponen untuk pekerjaan servis, bukan inventaris atau stok secara menyeluruh.

## 4.7 Pengelolaan Biaya dan Pembayaran

### A. Biaya servis

Biaya servis dicatat secara terpisah untuk setiap perangkat.

Sistem menghitung secara otomatis:

- Total biaya seluruh perangkat.
- Total biaya perangkat yang sudah selesai.
- Total pembayaran yang diterima.
- Sisa tagihan setiap perangkat.
- Sisa tagihan keseluruhan catatan servis.

Biaya komponen dan keuntungan belum dihitung secara terpisah pada versi pertama.

### B. Pembayaran langsung

- Pelanggan membayar biaya servis ketika mengambil perangkat.
- Pembayaran dicatat berdasarkan perangkat yang menjadi tanggungan pembayaran.

### C. Pembayaran menggunakan DP

- DP dibayarkan sebelum perbaikan dilanjutkan.
- DP digunakan untuk membeli komponen atau kebutuhan perbaikan.
- DP ditetapkan secara terpisah untuk setiap perangkat.
- DP biasanya diminta untuk biaya servis di atas Rp500.000 atau pekerjaan berisiko tinggi.
- Keputusan meminta DP ditentukan pengelola.
- DP dilakukan satu kali untuk setiap perangkat.
- Sisa pembayaran dilunasi sesuai kesepakatan ketika perangkat diambil.

### D. Pembatalan setelah pembayaran DP

Apabila pelanggan membatalkan perbaikan setelah membayar DP:

- Pengembalian DP diperbolehkan.
- Biaya komponen atau pengeluaran yang sudah terjadi dapat dikurangi dari jumlah DP.
- Sisa dana dikembalikan kepada pelanggan maksimal tujuh hari.
- Sistem mencatat jumlah DP awal, pengeluaran yang dikurangkan, jumlah pengembalian, tanggal, dan status pengembalian.

### E. Pembayaran beberapa perangkat sekaligus

Jika terdapat beberapa perangkat dalam satu catatan servis:

- Pelanggan dapat membayar perangkat yang sudah selesai.
- Pelanggan dapat membayar beberapa perangkat sekaligus.
- Pelanggan dapat menunggu seluruh perangkat selesai sebelum melakukan pembayaran.
- Pembayaran sekaligus diperbolehkan setelah teknisi mengetahui kerusakan dan biaya masing-masing perangkat.

Satu transaksi pembayaran dapat dialokasikan ke beberapa perangkat.

Sistem harus dapat mencatat nilai transaksi dan pembagian nominalnya ke setiap perangkat tanpa menghitung pembayaran yang sama lebih dari satu kali.

## 4.8 Pengambilan Perangkat

Sistem harus mencatat:

- Tanggal perangkat selesai diperbaiki.
- Tanggal dan waktu pelanggan diberi tahu bahwa perangkat siap diambil.
- Bukti pemberitahuan kepada pelanggan.
- Tanggal pengambilan.
- Status pengambilan setiap perangkat.

Sistem harus mendukung pengambilan sebagian perangkat dalam satu catatan servis.

## 4.9 Pengelolaan Garansi

Ketentuan garansi:

1. Garansi berlaku selama **7 (tujuh) hari kalender**.
2. Garansi dimulai setelah perangkat selesai diperbaiki dan diserahkan kepada pelanggan.
3. Kerusakan akibat terkena petir atau dampak sambaran petir tidak termasuk garansi.
4. Barang yang tidak diambil melewati batas tiga bulan memiliki garansi yang hangus.

Sistem harus mencatat tanggal mulai dan berakhirnya garansi setiap perangkat.

Garansi hanya berlaku untuk perangkat yang telah diperbaiki dan diserahkan kepada pelanggan.

## 4.10 Batas Waktu Pengambilan

Batas pengambilan adalah **3 (tiga) bulan sejak pelanggan diberi tahu bahwa perangkat siap diambil**.

Sistem harus:

- Menyimpan tanggal dan waktu pemberitahuan.
- Menyimpan bukti pemberitahuan.
- Memantau perangkat yang belum diambil.
- Menandai perangkat yang mendekati batas tiga bulan.
- Menandai perangkat yang melewati batas tiga bulan.

Apabila perangkat melewati batas tiga bulan, perangkat tersebut tidak lagi menjadi tanggung jawab tempat servis, termasuk apabila perangkat mengalami kerusakan atau kehilangan.

Garansi perangkat yang melewati batas tersebut dinyatakan hangus.

## 4.11 Nota Servis

Nota bersifat opsional dan hanya dibuat apabila pelanggan memintanya.

Seluruh data servis tetap wajib dicatat dalam aplikasi meskipun pelanggan tidak meminta nota.

Nota digital dapat memuat:

- Nomor servis.
- Informasi pelanggan.
- Informasi perangkat.
- Keluhan dan diagnosis.
- Biaya servis.
- DP dan pembayaran.
- Sisa tagihan.
- Ketentuan garansi.
- Ketentuan batas pengambilan.

## 4.12 Laporan dan Riwayat Servis

Sistem harus menyediakan informasi:

- Daftar catatan servis.
- Riwayat servis setiap pelanggan.
- Daftar perangkat berdasarkan status pengerjaan.
- Riwayat pembayaran dan pengembalian DP.
- Daftar perangkat yang siap diambil.
- Daftar perangkat yang mendekati atau melewati batas pengambilan.
- Ringkasan transaksi servis.

---

# 5. ATURAN BISNIS

| Kode | Aturan |
|---|---|
| BR-01 | Setiap catatan servis memiliki nomor unik. |
| BR-02 | Satu catatan servis dapat memiliki beberapa perangkat. |
| BR-03 | Setiap perangkat memiliki diagnosis, biaya, dan status sendiri. |
| BR-04 | Perbaikan dilanjutkan setelah pelanggan menyetujui estimasi biaya. |
| BR-05 | Biaya pemeriksaan tidak wajib. |
| BR-06 | Pembayaran pemeriksaan bersifat sukarela. |
| BR-07 | Biaya servis dicatat per perangkat. |
| BR-08 | DP ditetapkan secara terpisah untuk setiap perangkat. |
| BR-09 | DP dilakukan satu kali untuk setiap perangkat jika diperlukan. |
| BR-10 | Pembatalan setelah DP dapat disertai pengembalian dana setelah dikurangi pengeluaran yang sudah terjadi. |
| BR-11 | Pengembalian sisa DP dilakukan maksimal tujuh hari. |
| BR-12 | Pelunasan dilakukan sesuai perangkat yang diambil atau kesepakatan pelanggan. |
| BR-13 | Satu transaksi pembayaran dapat dialokasikan ke beberapa perangkat. |
| BR-14 | Nota dibuat apabila diminta pelanggan. |
| BR-15 | Garansi berlaku tujuh hari kalender sejak perangkat diserahkan. |
| BR-16 | Kerusakan akibat petir tidak termasuk garansi. |
| BR-17 | Batas pengambilan dihitung sejak pemberitahuan perangkat siap diambil. |
| BR-18 | Bukti pemberitahuan pelanggan dapat disimpan dalam sistem. |
| BR-19 | Barang yang melewati batas tiga bulan tidak lagi menjadi tanggung jawab tempat servis, termasuk apabila rusak atau hilang. |
| BR-20 | Garansi barang yang melewati batas tiga bulan dinyatakan hangus. |
| BR-21 | Urutan penerimaan menjadi dasar antrean, tetapi pekerjaan tertunda dapat dilewati. |
| BR-22 | Pemilik usaha menjadi penanggung jawab utama pekerjaan. |
| BR-23 | Pengambilan sebagian perangkat diperbolehkan. |
| BR-24 | Pembayaran sekaligus diperbolehkan setelah biaya masing-masing perangkat diketahui. |

---

# 6. KEBUTUHAN NONFUNGSIONAL

## 6.1 Kemudahan Penggunaan

Antarmuka harus sederhana dan mudah dipahami oleh pengelola.

## 6.2 Keamanan

- Sistem menyediakan autentikasi.
- Password disimpan menggunakan hashing.
- Halaman pengelolaan hanya dapat diakses pengguna berwenang.
- Lampiran bukti komunikasi hanya dapat diakses oleh pengguna yang memiliki hak akses.

## 6.3 Integritas Data

- Setiap catatan servis memiliki identitas unik.
- Pembayaran harus sesuai dengan biaya perangkat.
- Alokasi pembayaran tidak boleh melebihi nominal transaksi.
- Riwayat perubahan status dapat ditelusuri.
- Riwayat pembayaran dan pengembalian dana harus tercatat.
- Data transaksi penting tidak boleh dihapus sembarangan.

## 6.4 Pemeliharaan

Struktur aplikasi harus mudah dikembangkan untuk kebutuhan usaha berikutnya.

## 6.5 Penyimpanan Data

Sistem harus menyediakan penyimpanan data secara terstruktur, termasuk dokumen atau gambar bukti pemberitahuan pelanggan.

---

# 7. RANCANGAN ENTITAS DATABASE AWAL

| Entitas | Fungsi |
|---|---|
| users | Akun pengguna |
| customers | Data pelanggan |
| service_orders | Catatan utama servis |
| service_items | Perangkat dalam catatan servis |
| device_categories | Kategori perangkat |
| diagnoses | Diagnosis perangkat |
| service_status_histories | Riwayat status perangkat |
| payments | Transaksi pembayaran |
| payment_allocations | Alokasi pembayaran ke perangkat |
| refunds | Pengembalian dana atau DP |
| components | Komponen yang dibutuhkan |
| warranties | Data garansi perangkat |
| notification_records | Riwayat pemberitahuan pelanggan |

Relasi utama:

- Satu pelanggan dapat memiliki banyak catatan servis.
- Satu catatan servis dapat memiliki banyak perangkat.
- Satu perangkat dapat memiliki riwayat diagnosis dan status.
- Satu perangkat dapat memiliki catatan DP dan pembayaran.
- Satu transaksi pembayaran dapat dialokasikan ke satu atau beberapa perangkat.
- Pengembalian DP dikaitkan dengan pembayaran DP yang bersangkutan.
- Setiap perangkat yang diserahkan memiliki data garansi sendiri.
- Setiap pemberitahuan pelanggan dapat memiliki bukti lampiran.

Struktur akhir, atribut, primary key, foreign key, dan kardinalitas akan ditentukan pada tahap ERD dan perancangan database.

---

# 8. BATASAN VERSI PERTAMA (MVP)

Fitur prioritas:

1. Login.
2. Dashboard.
3. Pengelolaan pelanggan.
4. Pencatatan servis.
5. Beberapa perangkat dalam satu catatan.
6. Diagnosis dan estimasi biaya.
7. Persetujuan pelanggan.
8. Antrean dan status pengerjaan.
9. Pencatatan kebutuhan komponen.
10. Pembayaran DP per perangkat.
11. Pembayaran per perangkat maupun sekaligus.
12. Alokasi pembayaran.
13. Pengembalian DP.
14. Pengambilan sebagian perangkat.
15. Penyimpanan bukti pemberitahuan.
16. Garansi tujuh hari.
17. Pemantauan batas pengambilan tiga bulan.
18. Nota digital.
19. Riwayat servis dan laporan transaksi.

Fitur yang belum menjadi prioritas:

- Integrasi WhatsApp otomatis.
- Manajemen teknisi.
- Pembagian komisi.
- Inventaris dan stok komponen secara menyeluruh.
- Pencatatan keuntungan dan biaya operasional secara lengkap.

---

# 9. ASUMSI DAN DETAIL TEKNIS YANG AKAN DITETAPKAN PADA TAHAP DESAIN

Beberapa detail implementasi belum ditentukan secara rinci dan akan diselesaikan pada tahap perancangan sistem:

1. Format nomor servis dan nomor transaksi.
2. Mekanisme hak akses pengguna.
3. Format serta lokasi penyimpanan bukti WhatsApp.
4. Mekanisme perhitungan tanggal batas tiga bulan.
5. Mekanisme penghitungan tanggal akhir garansi tujuh hari.
6. Struktur tabel dan relasi pembayaran, alokasi pembayaran, serta pengembalian DP.
7. Mekanisme pembatalan dan pencatatan pengeluaran komponen.
8. Format laporan dan nota digital.

Hal-hal tersebut merupakan detail desain dan implementasi, bukan perubahan terhadap kebutuhan bisnis utama yang telah divalidasi.

---

# 10. PENUTUP

SRS menjadi acuan kebutuhan sistem Electronics Service Management System berdasarkan proses bisnis usaha servis elektronik yang telah divalidasi.

Aplikasi akan dibangun secara bertahap menggunakan pendekatan Minimum Viable Product (MVP) dan berorientasi pada kebutuhan operasional nyata.

Dokumen ini menjadi dasar untuk pembuatan diagram UML, ERD, rancangan database MySQL, dan implementasi aplikasi menggunakan Laravel.

