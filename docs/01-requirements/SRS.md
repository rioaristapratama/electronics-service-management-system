# SOFTWARE REQUIREMENTS SPECIFICATION (SRS)
# Electronics Service Management System

**Versi:** 1.3  
**Status:** Draft konsolidasi — siap ditinjau sebelum ERD  
**Jenis aplikasi:** Web-based Information System  
**Backend yang direncanakan:** PHP – Laravel  
**Database yang direncanakan:** MySQL  
**Frontend yang direncanakan:** Blade + Bootstrap  
**Version Control:** Git & GitHub  

---

## Riwayat Dokumen

| Versi | Status | Keterangan |
|---|---|---|
| 1.1 | Draft | Kebutuhan awal |
| 1.2 | Final kebutuhan bisnis awal | Penambahan aturan pembayaran, pengambilan, dan garansi |
| 1.3 | Draft konsolidasi | Penggabungan keputusan lanjutan, pemisahan MVP dan pengembangan berikutnya, serta penyederhanaan ruang lingkup desain |

> Dokumen ini merupakan konsolidasi kebutuhan. Status “siap ditinjau sebelum ERD” berarti aturan bisnis utama telah dirangkum, tetapi struktur tabel, constraint, dan detail teknis tetap akan ditetapkan pada tahap desain.

# 1. Pendahuluan

## 1.1 Tujuan

Electronics Service Management System adalah aplikasi web untuk membantu pencatatan dan pengelolaan operasional usaha jasa perbaikan perangkat elektronik. Sistem menggantikan pencatatan manual atau yang hanya bergantung pada ingatan dengan data terstruktur yang dapat ditelusuri.

Sistem menangani data pelanggan, penerimaan perangkat, diagnosis, estimasi dan persetujuan biaya, antrean pengerjaan, kebutuhan komponen, pembayaran, pengembalian dana, pemberitahuan, pengambilan perangkat, serta garansi.

## 1.2 Tujuan Pengembangan

1. Menyediakan satu sumber data untuk seluruh transaksi servis.
2. Memisahkan status, biaya, pembayaran, dan proses pengambilan untuk setiap perangkat.
3. Mengurangi kehilangan informasi dan kesalahan pencatatan.
4. Menyediakan riwayat perubahan dan bukti transaksi penting.
5. Menjadi fondasi pengembangan fitur lanjutan tanpa membebani versi pertama.

## 1.3 Pengguna Sistem

- **Owner:** pemilik usaha dan penanggung jawab utama. Memiliki kewenangan tertinggi.
- **Admin:** pengguna yang menjalankan administrasi sesuai izin yang diberikan Owner.
- **Technician:** pengguna yang melakukan pemeriksaan dan pekerjaan teknis sesuai izin.

Satu akun memiliki satu role aktif. Hak akses dapat diberikan atau dicabut oleh Owner. Identitas teknisi dan pembagian komisi tidak menjadi kebutuhan MVP.

## 1.4 Istilah

| Istilah | Definisi |
|---|---|
| Service Order | Satu catatan penerimaan yang dapat berisi beberapa perangkat |
| Service Item | Satu perangkat yang tercatat di dalam Service Order |
| DP | Pembayaran awal sebelum pekerjaan dilanjutkan |
| Payment Allocation | Pembagian nilai transaksi pembayaran ke satu atau beberapa perangkat |
| Ready Notification | Pemberitahuan bahwa perangkat telah siap diambil |
| Handover | Penyerahan fisik perangkat kepada pelanggan atau penerima yang sah |
| Warranty Claim | Permintaan pemeriksaan atas dugaan kerusakan dalam masa garansi |

# 2. Ruang Lingkup dan Prioritas

## 2.1 MVP — Versi Pertama

MVP berfokus pada alur servis inti yang dapat langsung digunakan di tempat usaha:

1. Login dan pengelolaan akun dengan hak akses dasar.
2. Dashboard operasional.
3. Pengelolaan data pelanggan dan kontak.
4. Pembuatan Service Order dan nomor servis otomatis.
5. Pencatatan beberapa perangkat dalam satu Service Order.
6. Kategori perangkat, keluhan, kondisi fisik, aksesori, dan foto penerimaan.
7. Diagnosis, estimasi biaya, dan persetujuan pelanggan.
8. Status antrean dan pengerjaan per perangkat.
9. Pencatatan komponen yang dibutuhkan untuk pekerjaan.
10. Pencatatan hasil perbaikan dan foto setelah pengerjaan.
11. Pembayaran, DP, alokasi pembayaran, dan pengembalian dana dasar.
12. Pemberitahuan siap diambil dan pencatatan hasil pengiriman/penerimaan pemberitahuan.
13. Pengambilan sebagian atau seluruh perangkat dengan bukti serah terima.
14. Garansi dasar tujuh hari dan pencatatan klaim dasar.
15. Pemantauan batas pengambilan tiga bulan.
16. Riwayat servis dan laporan operasional dasar.
17. Nota atau dokumen servis opsional jika diminta pelanggan.

## 2.2 Tahap Pengembangan Berikutnya

Fitur berikut tidak boleh menghambat rilis MVP:

- Integrasi WhatsApp otomatis.
- Portal pelanggan, tautan akses khusus, dan OTP.
- PDF historis dengan QR verifikasi dan proses penerbitan ulang.
- Workflow klaim garansi lanjutan: tenggat respons, pengingat, pemeriksaan ulang, pembukaan kembali, dan pengaitan klaim sebelumnya.
- Otorisasi pengambilan oleh pihak ketiga dengan banyak calon penerima.
- Workflow sengketa biaya dan penghentian pekerjaan yang kompleks.
- Persetujuan berjenjang untuk penghapusan foto dan pengelolaan bukti sengketa.
- Audit keamanan, notifikasi email, penguncian login, dan histori sesi secara lengkap.
- Inventaris/stock opname, pembukuan biaya operasional, laba, dan komisi teknisi.

## 2.3 Di Luar Tujuan Sistem Saat Ini

- Aplikasi mobile native.
- Integrasi pembayaran online/payment gateway.
- Akuntansi penuh.
- Manajemen gudang dan inventaris menyeluruh.
- Sistem penggajian dan komisi teknisi.

# 3. Gambaran Proses Bisnis

## 3.1 Penerimaan

1. Pelanggan menyerahkan satu atau beberapa perangkat.
2. Petugas memilih atau membuat data pelanggan.
3. Sistem membuat satu Service Order dengan nomor unik.
4. Setiap perangkat dicatat sebagai Service Item tersendiri.
5. Petugas mencatat kategori, nama/jenis perangkat, merek atau spesifikasi yang relevan, keluhan, kondisi fisik, dan aksesori yang diterima.
6. Foto kondisi awal dapat disimpan sebagai bukti.

Satu pelanggan dapat memiliki banyak Service Order. Satu Service Order dapat memiliki banyak Service Item. Setiap Service Item diproses secara independen.

## 3.2 Pemeriksaan, Estimasi, dan Persetujuan

1. Perangkat masuk tahap pemeriksaan.
2. Hasil diagnosis dan estimasi biaya dicatat untuk perangkat tersebut.
3. Estimasi disampaikan kepada pelanggan, umumnya melalui WhatsApp.
4. Keputusan pelanggan dicatat beserta waktu dan catatan pendukung.
5. Pekerjaan hanya dilanjutkan setelah estimasi yang berlaku disetujui.

Jika estimasi berubah, perubahan biaya harus dicatat sebagai riwayat estimasi dan memperoleh persetujuan baru sebelum pekerjaan yang terdampak dilanjutkan.

Jika pelanggan menolak perbaikan:
- Perangkat dirapikan dan dapat diambil pada hari yang sama.
- Tidak ada biaya pemeriksaan wajib.
- Pelanggan boleh memberikan pembayaran pemeriksaan secara sukarela.
- Status penolakan dicatat.

Jika pekerjaan tambahan dapat dipisahkan dari pekerjaan awal, pekerjaan awal yang telah disetujui dapat dilanjutkan. Jika tidak dapat dipisahkan, pekerjaan terkait ditunda sampai ada keputusan pelanggan atau Owner.

## 3.3 Antrean dan Pengerjaan

Urutan penerimaan menjadi dasar antrean, tetapi pekerjaan dapat dilewati sementara jika:
- Menunggu persetujuan pelanggan.
- Menunggu komponen.
- Mengalami kendala teknis atau keputusan.
- Pekerjaan dihentikan sementara atas permintaan pelanggan.

Pengerjaan normal diupayakan selesai pada hari yang sama. Antrean dan pemesanan komponen dapat memperpanjang waktu; pengiriman komponen online dapat memerlukan sekitar satu minggu atau lebih sesuai kondisi pemasok.

Owner tetap menjadi penanggung jawab kepada pelanggan meskipun pekerjaan dilakukan oleh teknisi lain.

## 3.4 Hasil Perbaikan

Setiap perangkat yang selesai ditangani memiliki:
- Hasil perbaikan: berhasil atau tidak berhasil.
- Catatan hasil atau alasan kegagalan.
- Foto setelah pengerjaan.

Foto setelah pengerjaan wajib tersedia sebelum perangkat ditandai siap diambil. Jika perbaikan tidak berhasil, alasan harus dicatat dan disampaikan kepada pelanggan. Tidak ada biaya pemeriksaan wajib untuk pekerjaan yang tidak berhasil atau perbaikan yang ditolak sebelum dimulai.

## 3.5 Pembayaran

Biaya dan saldo dihitung per perangkat. Pelanggan dapat:
- Membayar per perangkat.
- Membayar beberapa perangkat sekaligus.
- Membayar setelah satu perangkat selesai atau setelah seluruh perangkat selesai.
- Membayar DP sebelum pekerjaan dilanjutkan jika diminta.

Satu transaksi pembayaran dapat dialokasikan ke beberapa perangkat. Setiap alokasi harus jelas dan jumlah seluruh alokasi tidak boleh melebihi nilai transaksi.

## 3.6 Pemberitahuan dan Pengambilan

Tanggal perangkat selesai diperbaiki berbeda dari tanggal pemberitahuan siap diambil. Sistem menyimpan keduanya secara terpisah.

Batas pengambilan adalah tiga bulan kalender sejak pemberitahuan berhasil disampaikan kepada pelanggan, bukan sejak tanggal perbaikan selesai. Bukti atau catatan pemberitahuan harus disimpan.

Setiap perangkat dapat diambil secara terpisah. Setiap serah terima harus mencatat tanggal/waktu, kondisi perangkat, identitas penerima, dan bukti penerimaan.

Pihak ketiga hanya boleh mengambil perangkat setelah persetujuan pelanggan diverifikasi. Tidak boleh menyerahkan perangkat kepada anggota keluarga atau pihak lain hanya berdasarkan pengakuan lisan pihak yang datang tanpa verifikasi persetujuan pelanggan.

## 3.7 Garansi

Garansi dasar berlaku tujuh hari kalender sejak perangkat hasil perbaikan diserahkan kepada pelanggan. Garansi tidak dimulai pada saat perangkat selesai diperbaiki atau saat diberi status siap diambil.

Kerusakan akibat petir tidak termasuk garansi. Kerusakan akibat kelalaian pelanggan, misalnya perangkat terjatuh, dapat ditolak setelah pemeriksaan dan alasan disampaikan kepada pelanggan.

Klaim yang dilaporkan ketika garansi masih aktif tetap dicatat sebagai klaim tepat waktu meskipun pemeriksaan dilakukan setelah tanggal akhir garansi. Aturan klaim lanjutan dijelaskan pada bagian 6.

# 4. Kategori Perangkat

| Kategori | Contoh |
|---|---|
| TV & Display | LED TV, LCD TV, Smart TV, monitor, projector |
| Audio | Speaker, amplifier, radio, audio mixer, equalizer, crossover, subwoofer, wireless microphone, car audio |
| Home Appliances | Mesin cuci, kulkas, kipas angin, vacuum cleaner, dispenser, blender, mixer, juicer, exhaust fan, setrika listrik |
| Peralatan Dapur | Magic com / rice cooker |
| Kelistrikan & Power | Stabilizer, UPS, inverter, adapter, charger laptop, power supply |

TV tabung/CRT tidak termasuk perangkat yang diterima. Detail spesifikasi dibuat fleksibel sesuai jenis perangkat.

# 5. Kebutuhan Fungsional

## FR-01 — Autentikasi dan Pengguna

- Sistem menyediakan login untuk pengguna internal.
- Password disimpan dalam bentuk hash.
- Akun memiliki status aktif atau nonaktif.
- Akun yang dinonaktifkan tidak dapat login, tetapi riwayat dan transaksi yang dibuatnya tetap tersimpan.
- Akun tidak dihapus secara fisik melalui operasional normal.
- Role awal: Owner, Admin, dan Technician.
- Setiap akun memiliki satu role aktif.
- Hanya Owner yang dapat memberikan atau mencabut izin serta mengubah role.
- Perubahan role dan status akun dicatat.

## FR-02 — Pelanggan dan Kontak

- Sistem menyimpan nama dan alamat pelanggan.
- Nomor telepon disimpan pada entitas kontak terpisah agar satu pelanggan dapat memiliki beberapa nomor.
- Nomor telepon dan nama pelanggan tidak harus unik.
- Satu kontak aktif ditetapkan sebagai kontak utama.
- Beberapa kontak dapat ditandai sebagai nomor WhatsApp.
- Kontak dapat dinonaktifkan tanpa menghapus riwayatnya.
- Persetujuan penggunaan WhatsApp dicatat per nomor kontak.
- Pencabutan persetujuan untuk satu nomor tidak otomatis mencabut persetujuan nomor lain.
- Kegagalan pengiriman sementara tidak otomatis menonaktifkan nomor atau dianggap sebagai pencabutan persetujuan.
- Perubahan data pelanggan dan kontak harus menyimpan siapa yang mengubah, kapan, serta nilai perubahan yang relevan.
- Petugas dengan izin pengelolaan pelanggan dapat memperbarui data setelah verifikasi; tidak perlu persetujuan Owner untuk setiap koreksi rutin.

## FR-03 — Service Order dan Service Item

- Sistem membuat nomor Service Order unik dengan format yang direncanakan `SO-YYYY-MM-001`.
- Satu Service Order terhubung ke satu pelanggan.
- Satu Service Order dapat memiliki banyak Service Item.
- Data orang yang menyerahkan perangkat dapat berbeda dari pemilik/pelanggan dan dicatat terpisah.
- Setiap Service Item menyimpan kategori, nama perangkat, keluhan, kondisi fisik, aksesori, dan spesifikasi yang relevan.
- Setiap perangkat memiliki status, diagnosis, biaya, pembayaran, dan pengambilan masing-masing.
- Perbaikan ulang terhadap perangkat fisik yang sama dibuat sebagai Service Item baru pada Service Order baru; sistem dapat menyediakan referensi ke riwayat servis sebelumnya.

## FR-04 — Diagnosis dan Estimasi

- Diagnosis dicatat per perangkat.
- Estimasi biaya dicatat per perangkat.
- Perubahan estimasi disimpan sebagai riwayat, bukan menimpa nilai sebelumnya tanpa jejak.
- Persetujuan atau penolakan pelanggan dicatat beserta waktu dan catatan.
- Perubahan estimasi yang memerlukan persetujuan baru tidak boleh dikerjakan sebelum persetujuan diterima.

## FR-05 — Status dan Riwayat Pengerjaan

Status operasional utama per perangkat:

1. Baru Masuk
2. Pemeriksaan
3. Menunggu Persetujuan
4. Menunggu Komponen
5. Siap Dikerjakan
6. Dalam Pengerjaan
7. Selesai Diperbaiki
8. Siap Diambil
9. Sudah Diambil
10. Ditolak Pelanggan

Status tambahan yang hanya digunakan bila workflow terkait diimplementasikan:
- `PAUSED_PENDING_DECISION`: pekerjaan terkait dihentikan sementara menunggu keputusan.
- `DISPUTED`: terdapat keberatan/sengketa yang belum diselesaikan.
- `EXPIRED`: melewati batas pengambilan tiga bulan dan menunggu keputusan tindak lanjut.

Status tambahan tidak harus seluruhnya dibuat sebagai status inti MVP. Model status akhir ditetapkan pada tahap ERD dan implementasi agar tidak terjadi status yang tumpang tindih.

Setiap perubahan status menyimpan status sebelumnya, status baru, pelaku, waktu, dan alasan bila diperlukan.

## FR-06 — Komponen

- Sistem mencatat komponen yang dibutuhkan untuk Service Item.
- Data dasar meliputi nama komponen, jumlah, status kebutuhan/pemesanan, tanggal pemesanan, dan perkiraan kedatangan bila diketahui.
- Fitur ini bukan inventaris penuh dan tidak mencakup stock opname pada MVP.

## FR-07 — Foto Perangkat

- Sistem mendukung beberapa foto untuk setiap perangkat.
- Foto memiliki jenis, minimal `BEFORE` dan `AFTER`.
- Foto menyimpan lokasi/path file, deskripsi, waktu unggah, dan pengguna pengunggah.
- Foto AFTER wajib sebelum status Siap Diambil.
- Penggantian foto membuat versi baru; foto lama tidak langsung hilang dan riwayat penggantian disimpan.
- Penghapusan permanen foto bukan operasi rutin MVP dan harus mengikuti kebijakan audit serta persetujuan yang ditetapkan.

## FR-08 — Pembayaran dan Alokasi

- Pembayaran dicatat sebagai transaksi dengan nominal, tanggal, metode, dan pencatat.
- Satu pembayaran dapat dialokasikan ke satu atau beberapa Service Item.
- Satu Service Item dapat menerima beberapa alokasi pembayaran, misalnya DP dan pelunasan.
- Total alokasi tidak boleh melebihi nilai transaksi.
- Saldo perangkat dihitung dari biaya yang berlaku dikurangi alokasi pembayaran yang sah dan pengembalian yang relevan.
- Pembayaran beberapa perangkat sekaligus harus tetap memiliki alokasi yang jelas per perangkat.
- Koreksi transaksi dilakukan melalui transaksi koreksi/riwayat, bukan menghapus catatan pembayaran yang sudah terjadi.

### Ketentuan DP

- DP biasanya diminta jika biaya servis di atas Rp500.000 atau pekerjaan berisiko tinggi, misalnya perbaikan layar TV.
- Keputusan meminta DP berada pada Owner.
- DP ditetapkan per perangkat dan normalnya satu kali untuk setiap perangkat.
- Pelunasan dilakukan sesuai kesepakatan, umumnya saat pengambilan.

### Pengembalian DP

- Pembatalan setelah DP dapat memperoleh pengembalian dana.
- Pengeluaran yang sudah terjadi dan disepakati/dapat dipertanggungjawabkan dapat dikurangkan.
- Sisa dana dikembalikan maksimal tujuh hari.
- Pengembalian dicatat terpisah dari pembayaran awal.
- Pengembalian dapat dilakukan sebagian atau beberapa kali, tetapi total pengembalian tidak boleh melebihi jumlah yang dapat dikembalikan.
- Status selesai hanya diberikan setelah dana benar-benar dikembalikan.
- Persetujuan pengembalian berada pada Owner; pelaksanaan dapat dilakukan petugas yang memiliki izin.
- Pembatalan pengembalian yang belum dibayarkan harus memiliki alasan dan jejak perubahan.
- Pengembalian yang sudah selesai tidak dihapus atau dibatalkan; koreksi dilakukan melalui transaksi baru.

## FR-09 — Komunikasi dan Pemberitahuan

- Sistem mencatat komunikasi penting, bukan seluruh percakapan sehari-hari.
- Komunikasi penting meliputi persetujuan/penolakan estimasi, perubahan estimasi, keputusan Owner, kesepakatan biaya, penghentian pekerjaan, dan informasi penting lain.
- Catatan komunikasi menyimpan waktu, kanal, petugas, ringkasan, dan respons pelanggan bila ada.
- Riwayat pemberitahuan siap diambil disimpan terpisah atau sebagai jenis catatan pemberitahuan yang dapat ditelusuri.
- Nomor penerima disimpan sebagai snapshot agar riwayat tetap akurat walaupun kontak pelanggan berubah.
- Integrasi WhatsApp otomatis bukan bagian MVP; pencatatan manual tetap dapat dilakukan.

## FR-10 — Pengambilan dan Serah Terima

- Pengambilan dapat dilakukan per perangkat.
- Serah terima mencatat waktu, kondisi perangkat, nama penerima, petugas yang menyerahkan, dan bukti penerimaan.
- Bukti dapat berupa tanda tangan digital atau konfirmasi tertulis yang dapat diverifikasi.
- Pihak ketiga hanya dapat menerima perangkat jika persetujuan pelanggan dan identitas penerima telah diverifikasi.
- Persetujuan pihak ketiga dapat dicabut sebelum perangkat diserahkan.
- Jika persetujuan melalui telepon, petugas mencatat hasil komunikasi; rekaman panggilan tidak diwajibkan.
- Perangkat tidak boleh diserahkan jika persetujuan belum terverifikasi.

## FR-11 — Batas Pengambilan dan Perangkat Terlambat Diambil

- Tenggat tiga bulan dihitung dari pemberitahuan siap diambil yang berhasil disampaikan.
- `ready_at` dan `notification_delivered_at` merupakan waktu yang berbeda dan harus dapat dibedakan.
- Pelanggan dapat meminta perpanjangan sebelum tenggat berjalan berakhir.
- Owner memutuskan perpanjangan, menetapkan tenggat baru, dan mencatat alasan.
- Perpanjangan dapat diberikan lebih dari sekali; setiap keputusan dicatat.
- Lewat tenggat tidak otomatis menjadikan perangkat milik tempat servis.
- Owner menentukan tindak lanjut: tetap disimpan, dikembalikan berdasarkan kesepakatan khusus, atau proses disposisi lain yang sesuai hukum dan kesepakatan.
- Sebelum penjualan/pemusnahan, rencana final notice dan masa tunggu harus diterapkan sesuai kebijakan operasional yang disepakati: pemberitahuan final pertama dengan tenggat 30 hari sejak berhasil disampaikan; jika pelanggan merespons meminta waktu, Owner dapat memberi tenggat tambahan. Jika tidak ada penyelesaian setelah tenggat itu, pemberitahuan final kedua memberi 14 hari. Respons terhadap pemberitahuan kedua dapat dipertimbangkan Owner sebagai kesempatan terakhir.
- Perangkat tidak boleh didisposisi ketika klaim garansi yang dilaporkan tepat waktu masih berjalan.
- Detail disposisi final harus ditinjau dari sisi hukum dan perjanjian pelanggan sebelum diaktifkan di sistem.

## FR-12 — Garansi dan Klaim

- Setiap perbaikan berhasil yang telah diserahkan kepada pelanggan memperoleh garansi tujuh hari kalender.
- Garansi dihitung dari waktu serah terima aktual per perangkat.
- Perbaikan gagal tidak memperoleh garansi perbaikan.
- Kerusakan akibat petir dikecualikan.
- Kerusakan akibat kelalaian pelanggan dapat ditolak berdasarkan hasil pemeriksaan dan alasan harus disampaikan.
- Klaim yang pertama kali dilaporkan saat masa garansi aktif tetap dianggap tepat waktu meskipun pemeriksaan dilakukan setelah masa garansi berakhir.
- Waktu laporan pertama pelanggan (`reported_at`) dibedakan dari waktu petugas mencatatnya (`recorded_at`).
- Jika pelanggan diminta membawa perangkat, tenggat awal yang disepakati adalah tujuh hari kalender sejak laporan; pengingat hari kelima dapat diterapkan pada tahap lanjutan.
- Jika perangkat telah diterima dalam tenggat, keterlambatan antrean pemeriksaan tidak membatalkan klaim.
- Teknisi berwenang dapat menerima/menolak klaim. Owner dapat meninjau atau mengubah keputusan dengan alasan dan mempertahankan keputusan sebelumnya.
- Pelanggan mendapat satu kesempatan pemeriksaan ulang gratis. Hasil pemeriksaan ulang menjadi keputusan berjalan, kecuali Owner meninjau kembali.
- Jika klaim ditolak, pelanggan dapat memilih perbaikan berbayar dengan estimasi dan persetujuan baru.
- Beberapa klaim dapat diajukan selama masa garansi jika memiliki alasan/kejadian yang berbeda.
- Klaim yang dibatalkan pelanggan sebelum keputusan final dicatat sebagai batal dan tidak dibuka kembali; pengajuan baru harus menjadi klaim baru yang terhubung ke klaim sebelumnya.
- Klaim yang ditutup karena pelanggan tidak merespons dapat diajukan permintaan pembukaan kembali kepada Owner dengan alasan. Mekanisme rinci ini termasuk tahap lanjutan.
- Klaim yang dilaporkan tepat waktu menahan proses disposisi perangkat sampai klaim selesai atau dibatalkan.

## FR-13 — Nota dan Dokumen

- Nota bersifat opsional dan dibuat jika diminta pelanggan.
- Data servis tetap wajib disimpan walaupun nota tidak diminta.
- Nota memuat nomor servis, data pelanggan, perangkat, keluhan/diagnosis, biaya, pembayaran, saldo, dan ketentuan garansi/pengambilan yang relevan.
- PDF historis, QR verifikasi, snapshot, dan proses penerbitan ulang merupakan pengembangan lanjutan.

## FR-14 — Laporan

MVP menyediakan:
- Daftar Service Order.
- Riwayat servis pelanggan.
- Daftar perangkat berdasarkan status.
- Daftar perangkat siap diambil.
- Daftar perangkat mendekati atau melewati tenggat.
- Riwayat pembayaran dan pengembalian.
- Ringkasan transaksi servis.

Laporan laba bersih dan biaya operasional lengkap bukan bagian MVP.

# 6. Aturan Bisnis

| Kode | Aturan |
|---|---|
| BR-01 | Satu pelanggan dapat memiliki banyak Service Order. |
| BR-02 | Satu Service Order dapat memiliki banyak Service Item. |
| BR-03 | Status, diagnosis, biaya, pembayaran, garansi, dan pengambilan dikelola per perangkat. |
| BR-04 | Perbaikan hanya dilanjutkan setelah persetujuan estimasi yang berlaku. |
| BR-05 | Biaya pemeriksaan tidak wajib; pembayaran pemeriksaan bersifat sukarela. |
| BR-06 | Perubahan estimasi yang memengaruhi pekerjaan memerlukan persetujuan baru. |
| BR-07 | Satu transaksi pembayaran dapat dialokasikan ke beberapa perangkat. |
| BR-08 | Total alokasi pembayaran tidak boleh melebihi nominal pembayaran. |
| BR-09 | DP ditentukan Owner, umumnya untuk biaya di atas Rp500.000 atau pekerjaan berisiko tinggi. |
| BR-10 | Pengembalian DP memperhitungkan pengeluaran yang sah dan ditargetkan selesai maksimal tujuh hari. |
| BR-11 | Pengembalian yang selesai tidak dihapus; koreksi dilakukan dengan transaksi baru. |
| BR-12 | Nota hanya dibuat jika diminta pelanggan. |
| BR-13 | Foto AFTER wajib sebelum perangkat dinyatakan siap diambil. |
| BR-14 | Garansi tujuh hari kalender dimulai saat perangkat diserahkan kepada pelanggan. |
| BR-15 | Kerusakan akibat petir tidak termasuk garansi. |
| BR-16 | Tenggat pengambilan tiga bulan dimulai dari pemberitahuan siap diambil yang berhasil disampaikan. |
| BR-17 | Tanggal selesai perbaikan tidak menggantikan tanggal pemberitahuan siap diambil. |
| BR-18 | Pengambilan sebagian perangkat diperbolehkan. |
| BR-19 | Setiap serah terima harus memiliki bukti penerimaan yang dapat diverifikasi. |
| BR-20 | Pihak ketiga tidak boleh mengambil tanpa persetujuan pelanggan yang terverifikasi. |
| BR-21 | Perangkat melewati tenggat tidak otomatis menjadi milik tempat servis. |
| BR-22 | Perangkat tidak boleh didisposisi saat klaim tepat waktu masih berjalan. |
| BR-23 | Riwayat transaksi dan perubahan penting tidak dihapus melalui operasi normal. |
| BR-24 | Akun atau kontak yang dinonaktifkan tetap memiliki riwayat yang dapat ditelusuri. |
| BR-25 | Perbaikan ulang perangkat fisik dibuat sebagai catatan servis baru dan dapat ditautkan ke riwayat sebelumnya. |

# 7. Kebutuhan Nonfungsional

## 7.1 Kemudahan Penggunaan
- Antarmuka sederhana, konsisten, dan dapat digunakan pada desktop maupun layar mobile.
- Formulir hanya meminta data yang relevan untuk proses yang sedang dilakukan.
- Status dan saldo perangkat ditampilkan dengan jelas.

## 7.2 Keamanan
- Password disimpan menggunakan algoritma hashing yang sesuai.
- Halaman dan tindakan dibatasi berdasarkan hak akses.
- File bukti tidak boleh dapat diakses publik tanpa otorisasi.
- Validasi dilakukan pada sisi server, bukan hanya browser.
- Operasi sensitif harus memiliki jejak audit.

## 7.3 Integritas Data
- Nomor Service Order unik.
- Foreign key menjaga hubungan data.
- Nominal alokasi dan pengembalian divalidasi agar tidak melebihi batas.
- Perubahan status dan transaksi penting memiliki histori.
- Data transaksi tidak dihapus secara fisik melalui penggunaan normal.

## 7.4 Pemeliharaan
- Aplikasi menggunakan struktur Laravel yang modular dan mudah diuji.
- Logika bisnis penting tidak hanya ditempatkan pada tampilan.
- Database dirancang agar fitur lanjutan dapat ditambahkan tanpa merombak seluruh sistem.

## 7.5 Pencadangan
- Database dan file bukti perlu dicadangkan secara berkala.
- Prosedur pemulihan perlu diuji sebelum aplikasi digunakan sebagai pencatatan utama.

# 8. Prinsip Desain Data

Bagian ini menjadi pedoman ERD, bukan daftar tabel final.

1. **Pisahkan transaksi utama dari detail perangkat.** `service_orders` mewakili penerimaan; `service_items` mewakili perangkat.
2. **Pisahkan pembayaran dari alokasinya.** Satu transaksi dapat membayar beberapa perangkat; jangan menggandakan transaksi untuk setiap perangkat.
3. **Simpan histori hanya ketika ada kebutuhan audit atau perubahan berulang.** Tidak setiap kolom perlu tabel histori tersendiri.
4. **Gunakan tabel kontak untuk nomor pelanggan.** Jangan menyimpan beberapa nomor dalam satu kolom.
5. **Pisahkan waktu kejadian yang maknanya berbeda.** Contoh: selesai diperbaiki, pemberitahuan berhasil, dan serah terima.
6. **Gunakan status yang terkontrol.** Status tambahan untuk workflow lanjutan tidak perlu mempersulit alur MVP.
7. **Gunakan soft delete/deaktivasi secara selektif.** Data transaksi, pembayaran, dan bukti historis tidak dihapus secara fisik melalui operasi normal.
8. **Simpan snapshot ketika nilai historis harus tetap akurat.** Contoh: nomor penerima pemberitahuan pada saat pesan dikirim dan isi dokumen saat diterbitkan.
9. **Jangan membuat tabel hanya untuk satu atribut atau satu skenario langka.** Gabungkan ke tabel histori/audit yang sesuai selama relasinya tetap jelas.
10. **Tabel final ditetapkan melalui ERD dan validasi implementasi.** Daftar entitas pada tahap sebelumnya bukan kewajiban untuk membuat semua tabel.

# 9. Kandidat Kelompok Entitas untuk ERD

Kelompok berikut adalah kandidat konseptual. Nama dan jumlah tabel dapat disederhanakan pada tahap ERD.

## 9.1 Inti operasional MVP
- Pengguna, role, dan izin.
- Pelanggan dan kontak pelanggan.
- Kategori perangkat.
- Service Order dan Service Item.
- Diagnosis dan riwayat status.
- Riwayat estimasi serta keputusan pelanggan.
- Foto perangkat.
- Komponen dan kebutuhan komponen per perangkat.
- Pembayaran dan alokasi pembayaran.
- Pengembalian dana.
- Catatan komunikasi dan pemberitahuan.
- Garansi dan klaim dasar.
- Catatan serah terima.
- Audit perubahan penting.

## 9.2 Entitas lanjutan
- Histori persetujuan kontak dan WhatsApp.
- Percobaan notifikasi dan histori pengiriman.
- Histori login, penguncian akun, dan sesi.
- Histori perubahan role dan status akun.
- Histori pengembalian dana dan keberatan.
- Pemeriksaan ulang, histori status klaim, dan permintaan pembukaan kembali.
- Otorisasi penerima pihak ketiga dan histori pencabutannya.
- Permintaan penghapusan foto dan audit penghapusan.
- Sengketa, penghentian pekerjaan, dan keputusan penyelesaiannya.
- Dokumen PDF, versi dokumen, QR, dan verifikasi.
- Permintaan perpanjangan tenggat pengambilan dan disposisi perangkat.

# 10. Asumsi dan Batas Keputusan

1. Teknologi Laravel, MySQL, Blade, dan Bootstrap merupakan pilihan awal implementasi; versi dan konfigurasi teknis ditetapkan sebelum coding.
2. Nomor Service Order menggunakan pola `SO-YYYY-MM-001`; aturan reset urutan per periode harus ditetapkan saat implementasi.
3. Batas tujuh hari dan tiga bulan menggunakan hari kalender, bukan hari kerja.
4. Waktu kejadian disimpan konsisten dan ditampilkan menggunakan zona waktu operasional usaha.
5. Integrasi WhatsApp otomatis tidak diperlukan untuk MVP; petugas dapat mencatat komunikasi manual.
6. Kebijakan perangkat yang melewati tenggat perlu ditinjau secara hukum dan dituangkan dalam informasi/persetujuan pelanggan sebelum fitur disposisi diaktifkan.
7. Aturan teknis yang belum ditentukan tidak boleh ditebak saat coding; keputusan dicatat sebagai asumsi desain dan diperbarui bila ada bukti operasional.

# 11. Kriteria Kesiapan Menuju ERD

SRS ini dapat digunakan untuk memulai ERD setelah pemeriksaan berikut:

- [ ] Alur penerimaan satu pesanan dengan banyak perangkat dipahami.
- [ ] Status dan proses per perangkat dipahami.
- [ ] Relasi pembayaran dan alokasi pembayaran dipahami.
- [ ] Perbedaan waktu selesai, notifikasi, dan serah terima dipahami.
- [ ] Aturan dasar DP, pengembalian, dan garansi dipahami.
- [ ] Fitur MVP dan fitur lanjutan telah dipisahkan.
- [ ] Kandidat tabel akan dievaluasi berdasarkan kebutuhan relasi, bukan disalin mentah-mentah.

# 12. Penutup

SRS versi 1.3 merupakan dokumen konsolidasi kebutuhan Electronics Service Management System. Dokumen ini menjadi dasar penyusunan ERD, rancangan database, arsitektur aplikasi, dan implementasi bertahap.

Pengembangan dimulai dari MVP yang menyelesaikan alur servis inti. Fitur lanjutan ditambahkan setelah alur utama stabil dan benar-benar dibutuhkan dalam operasional.

**Status dokumen: Draft konsolidasi — tahap berikutnya adalah audit kandidat entitas dan penyusunan ERD.**
