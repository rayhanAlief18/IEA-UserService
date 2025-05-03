Request Get Order By User:

Menampilkan riwayat pesanan berdasarkan ID user.

📍 Endpoint:
GET /api/users/{id}/history-order

✅ Request

Method: GET
URL: http://localhost:8000/api/users/{id}/history-order (ganti {id} dengan ID user yang dicari)

Parameter URL:
id (integer) – ID dari user yang ingin diambil riwayat pesannya


✅ Response Sukses (201 Created)

{
	"message": "Berhasil ambil data order by User",
	"user": {
		"id": 6,
		"name": "diamante",
		"email": "diamante@gmail.com",
		"email_verified_at": null,
		"photo": "photoProfile/QpIryWlruN6O0xuxEQFFjfDPXm4q5bfeHiiCXqQv.jpg",
		"role": "karyawan",
		"status": "non-aktif",
		"created_at": "2025-04-30T06:03:58.000000Z",
		"updated_at": "2025-04-30T06:03:58.000000Z"
	},
	"data": [
		{
			"id": 1,
			"id_user": 6,
			"id_kendaraan": 3,
			"pelayanan": "Cuci Menyeluruh",
			"biaya": 75000,
			"durasi_pengerjaan": 45,
			"no_antrian": 1,
			"status": "Menunggu",
			"created_at": "2025-04-30T06:55:59.000000Z",
			"updated_at": "2025-04-30T06:55:59.000000Z"
		},
		{
			"id": 3,
			"id_user": 6,
			"id_kendaraan": 2,
			"pelayanan": "Cuci Menyeluruh",
			"biaya": 30000,
			"durasi_pengerjaan": 20,
			"no_antrian": 3,
			"status": "Menunggu",
			"created_at": "2025-04-30T12:10:06.000000Z",
			"updated_at": "2025-04-30T12:10:06.000000Z"
		}
	]
}


❌ Response Gagal (404 Not Found – User Tidak Ditemukan)

{
  "message": "User tidak ditemukan"
}

❌ Response Error (500 Internal Server Error – Gagal Mengambil Data)

{
  "message": "Gagal mengambil data history order",
  "error": "Exception message here"
}

❌ Response Error (503 Service Unavailable – Order Service Tidak Tersedia)

{
  "message": "Maaf sistem order belum aktif"
}


🔄 Contoh CURL Request

curl -X GET http://localhost:8000/api/users/1/history-order


📌 Catatan

Endpoint ini mengembalikan riwayat pesanan dari layanan order yang terpisah (via HTTP request ke order-service).

Jika layanan order tidak tersedia, akan mengembalikan pesan error bahwa sistem order belum aktif.

Pastikan user yang diminta ada dalam database.



