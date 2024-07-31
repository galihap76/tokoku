## Tokoku 🛒

Tokoku merupakan platfrom marketplace produk digital yang menjual produk digital secara online dengan payment gateway Midtrans. Saya membangun ini sesuai dengan kata **tokoku** yang artinya platfrom ini di bangun untuk menjual produk milik saya sendiri. Produk tersebut bisa saja produk source code program aplikasi maupun file PDF yang bersifat produk digital.

Tokoku memiliki sistem multi user yang arti nya ada dua role yaitu admin dan customer. Admin adalah role milik saya dan customer sebagai pembeli. Tokoku di bangun dengan framework Laravel 10 dan MySQL nya sebagai backend. Untuk front end menggunakan bootstrap dan JavaScript. 

Alur proses bisnis aplikasi web ini sama dengan layaknya toko pada umum nya. Jadi ketika customer membeli suatu produk, lalu checkout, pilih pembayaran Midtrans, dan jika sukses maka customer bisa mengunduh produk yang di simpan dari sistem aplikasi. Customer akan menerima notifikasi email, misal invoice milik customer adalah **80xxxx** telah membeli suatu produk.

## Fitur 📱
Untuk fitur, mohon Anda bisa melihat pada <a href="https://github.com/galihap76/tokoku/releases/">release application</a>.

## Install ⚙️ 
Jika Anda seorang developer atau mahasiswa ingin menggunakan dan mengubah source code yang ada pada aplikasi web ini, maka perintah nya sebagai berikut : 

1. Lakukan git clone :
```
git clone https://github.com/galihap76/tokoku.git
```

2. Masuk ke direktori tokoku :
```
cd tokoku
```

3. Install package bawahan Laravel :
 
```
composer install
```

4. Generate key :
```
php artisan key:generate
```

5. Copy .env.example ke .env :
```
copy .env.example .env
```

6. Import database yang berada pada folder **public/assets/** dan cari nama file **db_tokoku.sql**.

7. Buka **.env** lalu ubah konfigurasi database sesuai yang ingin dipakai :
```
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
```

8. Masuk dan daftar <a href="https://dashboard.midtrans.com/login">Midtrans</a> untuk mendapatkan MERCHANT, CLIENT, dan SECRET key. Lalu copas ini ke **.env**  :
```
MIDTRANS_MERCHANT_ID = <MASUKKAN MERCHANT ID MILIK ANDA>
MIDTRANS_CLIENT_KEY = <MASUKKAN CLIENT KEY MILIK ANDA>
MIDTRANS_SERVER_KEY = <MASUKKAN SERVER KEY MILIK ANDA>
```

9. Tokoku memiliki sistem Single Sign On (SSO) Google, jadi Anda perlu masuk dan daftar pada <a href="https://console.cloud.google.com/apis/dashboard">console.cloud.google</a> untuk mendapatkan CLIENT dan SECRET key.

10. Copas ini ke **.env** untuk bisa menggunakan sistem SSO Google :
```
GOOGLE_CLIENT_ID= <MASUKKAN CLIENT ID ANDA>
GOOGLE_CLIENT_SECRET= <MASUKKAN CLIENT SECRET ANDA>
GOOGLE_REDIRECT_URI= <MASUKKAN REDIRECT URI APLIKASI WEB ANDA>
```

13. Untuk mengirim dan menerima email menggunakan protokol SMTP, daftar pada situs <a href="https://mailtrap.io/">mailtrap</a> untuk bahan percobaan.

14. Terakhir, sesuaikan konfigurasi MAIL Anda sendiri di **.env** :
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME= <MASUKKAN USERNAME ANDA>
MAIL_PASSWORD= <MASUKKAN PASSWORD ANDA>
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

15. Selesai.

## Screenshots 📸
| ![image](https://github.com/user-attachments/assets/9237bf65-213a-45d7-bc7a-6226113482dd) | ![image](https://github.com/user-attachments/assets/82bb6892-dc60-4d37-b636-1bf10c7e7960)
| ------------------------------------------------------------ | ------------------------------------------------------------ |
| Login                                        | Pendaftaran                      |
| ![image](https://github.com/user-attachments/assets/2d755629-0689-4ca9-afaf-6b4d4ba826c9) | ![image](https://github.com/user-attachments/assets/80094853-b1e3-4ca1-8172-afe8d34e14bc)
| Lupa Password                                         | Reset Password                           |
| ![image](https://github.com/user-attachments/assets/e7cfbce2-b561-42d9-8d73-eba5b1faad7e) | ![image](https://github.com/user-attachments/assets/f1da0bfc-64a0-4de1-8f46-39e631870ce6)
| Dashboard (Admin)                                         | Menu Produk (Admin)                   |
| ![image](https://github.com/user-attachments/assets/7c3a617d-e02e-4ebb-874c-368b36a4bdd1) | ![image](https://github.com/user-attachments/assets/d6e79b1b-ec98-4aad-84a3-c591badff6e8)
| Tambah Produk (Admin)                                         | Update Produk (Admin)                 |
| ![image](https://github.com/user-attachments/assets/f2647401-69a2-4835-b534-f82269b16bc4) | ![image](https://github.com/user-attachments/assets/4094681c-ff16-440b-bd52-dfa16066d9b3)
| Screenshots Produk (Admin & Customer)                                         | Produk Terjual (Admin)                 |
| ![image](https://github.com/user-attachments/assets/1792c82a-0ba9-4a94-9513-0f6d15abf6e7) | ![image](https://github.com/user-attachments/assets/34713afa-00fa-4110-b349-11cc029fcfdf)
| Ganti Password (Admin & Customer)                                         | Extract Screenshots (Admin)                 |
| ![image](https://github.com/user-attachments/assets/f5db2e26-62d3-4dc9-9f25-c4f7b6641be5) | ![image](https://github.com/user-attachments/assets/1cbd1033-f3b6-4698-8287-20c871753669)
| Profile Customer (Customer)                                         | Menu Produk (Customer)                 |
| ![image](https://github.com/user-attachments/assets/389aa8d6-8301-4b29-baa9-dbf205a96ab6) | ![Screenshot (28)](https://github.com/user-attachments/assets/8137b37d-24d7-48fe-a1bf-530ddfba0735)
| Beli Produk / Checkout (Customer)                                         | Metode Pembayaran (Customer)                 |
| ![image](https://github.com/user-attachments/assets/43dd1bd3-a31c-4ab5-b954-3772ccfc2268) | ![image](https://github.com/user-attachments/assets/d6bbdfff-aeda-4b5b-b0a3-7bd39d1632dd)
| Bukti Pembayaran (Customer)                                         | Unduh Bukti Pembayaran (Customer)                 |
| ![Screenshot (29)](https://github.com/user-attachments/assets/992b7ac9-c447-4e0c-b64f-7d4c09c734a0) | ![Screenshot (30)](https://github.com/user-attachments/assets/d04b8e8b-9594-482f-a392-39910071a933)
| Notifikasi Reset Password (Admin & Customer)                                         | Notifikasi Email Beli Produk (Customer)                 |

## Penutup

Aplikasi web ini akan saya perbarui jika saya memang ada waktu. Sekian terima kasih. 













