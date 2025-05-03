Request Register :

Mendaftarkan user baru ke sistem dengan nama, email, password, foto, role, dan status.

| Field      | Type   | Required | Description                            |
| ---------- | ------ | -------- | -------------------------------------- |
| `name`     | string | ✅        | Nama lengkap user                      |
| `email`    | string | ✅        | Email user, harus unik                 |
| `password` | string | ✅        | Password minimal 6 karakter            |
| `photo`    | file   | ✅        | Foto profil (jpg, jpeg, png, maks 2MB) |
| `role`     | string | ✅        | Role user (`karyawan` atau `admin`) default : karyawan    |
| `status`   | string | ✅        | Status user (`aktif` atau `non-aktif`) default : non-aktif |

Validasi :
| Field      | Rule                          | Pesan Kesalahan                                 |
| ---------- | ----------------------------- | ----------------------------------------------- |
| `name`     | required, max:255             | Nama wajib diisi, maksimal 255 karakter         |
| `email`    | required, email, unique       | Email wajib diisi, format harus valid, unik     |
| `password` | required, min:6               | Password wajib, minimal 6 karakter              |
| `photo`    | required, image, mimes, max   | Foto wajib, harus gambar JPG/JPEG/PNG, maks 2MB |
| `role`     | required, in\:karyawan,admin  | Role hanya boleh 'karyawan' atau 'admin'        |
| `status`   | required, in\:aktif,non-aktif | Status hanya boleh 'aktif' atau 'non-aktif'     |

Contoh Request (cURL)
curl -X POST http://localhost:8000/api/register \
  -F "name=Rayhan Alief" \
  -F "email=rayhan@example.com" \
  -F "password=secret123" \
  -F "photo=@/path/to/photo.jpg" \
  -F "role=karyawan" \
  -F "status=aktif"
	
Response Json:
✅ Contoh Respons Sukses (201 Created)

{
  "message": "User rigistered Successfully",
  "user": {
    "id": 12,
    "name": "Rayhan Alief",
    "email": "rayhan@example.com",
    "photo": "photoProfile/ZvJk321.jpg",
    "role": "karyawan",
    "status": "aktif",
    "created_at": "2025-05-03T10:25:45.000000Z"
  }
}

❌ Contoh Respons Gagal Validasi (422 Unprocessable Entity)

{
  "errors": {
    "email": ["Email sudah terdaftar."],
    "photo": ["Foto wajib diisi."]
  }
}

❌ Contoh Respons Gagal Server (500 Internal Server Error)

{
  "message": "failed to register",
  "error": "SQLSTATE[23000]: Integrity constraint violation: ..."
}

📝 Catatan

Foto disimpan di folder storage/app/public/photoProfile.
Pastikan sudah menjalankan php artisan storage:link agar gambar bisa diakses publik.


	

