Request Get User By Id:

Menampilkan data user berdasarkan id yang diminta.

📍 Endpoint:

GET /api/users/{id}

✅ Request

Method: GET URL: http://localhost:8000/api/users/1 (ganti 1 dengan ID user yang dicari)

Parameter URL: id (integer) – ID dari user yang ingin diambil


✅ Response Sukses (201 Created)

{
	"message": "Berhasil menampilkan user berdasarkan ID",
	"data": {
		"id": 5,
		"name": "dofi",
		"email": "dofi@gmail.com",
		"email_verified_at": null,
		"photo": "photoProfile/uw0HAbx7BShcoFw8ysdge05ke9cvRTU4dFNZS4gy.jpg",
		"role": "admin",
		"status": "non-aktif",
		"created_at": "2025-04-29T13:34:20.000000Z",
		"updated_at": "2025-04-29T13:34:20.000000Z"
	}
}


❌ Response Gagal (404 Not Found – Data Tidak Ada)

{
  "message": "User dengan ID tersebut tidak ditemukan."
}


❌ Response Error (500 Internal Server Error)

{
  "message": "Gagal menampilkan data user!",
  "error": "Exception message here"
}

🔄 Contoh CURL Request

curl -X GET http://localhost:8000/api/users/1
📌 Catatan
Pastikan ID yang diminta benar-benar ada dalam tabel users.

Endpoint akan mengembalikan HTTP status 404 jika data tidak ditemukan
