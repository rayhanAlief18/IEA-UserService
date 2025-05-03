Request getUser:

Menampilkan seluruh data user dari database.

End Point:
GET /api/users

✅ Request

Method: GET
URL: http://localhost:8000/api/users

✅ Response Sukses (200 OK / 201 Created)

{
  "message": "Berhasil menampilkan data user",
  "data": [
    {
      "id": 1,
      "name": "Rayhan Alief",
      "email": "rayhan@example.com",
      "photo": "photoProfile/example.jpg",
      "role": "karyawan",
      "status": "aktif",
      "created_at": "2025-05-03T08:00:00.000000Z",
      "updated_at": "2025-05-03T08:00:00.000000Z"
    },
    ...
  ]
}

❌ Response Error (500 Internal Server Error)

{
  "message": "Gagal menampilkan data user !",
  "error": "Error message here"
}

🔄 Contoh CURL Request

curl -X GET http://localhost:8000/api/users


📌 Catatan

Endpoint ini tidak memiliki parameter.
Gunakan untuk menampilkan semua data user yang tersedia di sistem.