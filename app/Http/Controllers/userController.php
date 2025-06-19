<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Exception;
use Throwable;    
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    public function index(){
        try{
            $data = User::all();
            return response()->json([
                'message'=>'Berhasil menampilkan data user',
                'data'=>$data,
            ],201);
        }catch(Exception $e){
            return response()->json([
                'message'=>'Gagal menampilkan data user !',
                'error'=>$e->getMessage(),
            ],500);
        };
    }

    public function getUserById($id){
        try{
            $data = User::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'User dengan ID tersebut tidak ditemukan.',
                ], 404);
            }
            return response()->json([
                'message'=>'Berhasil menampilkan user berdasarkan ID',
                'data'=>$data,
            ],201);
        }catch(Exception $e){
            return response()->json([
                'message'=>'Gagal menampilkan data user !',
                'error'=>$e->getMessage(),
            ],500);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|string',
            'password'=>'string|string|min:8'
        ],[
            'email.required' => 'email wajib diisi.',
            'email.string' => 'email harus berupa teks.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::where('email',$request->email)->first();

        if ($user && ! \Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password salah.'
            ], 401);
        }

        if (!$user &&  \Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'email salah.'
            ], 401);
        }

        if (! $user || ! \Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'email dan password salah.'
            ], 401);
        }

        //Hapus token lama
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'role' => 'required|string|in:karyawan,admin', 
                'status' => 'required|string|in:aktif,non-aktif',
            ], [
                'name.required' => 'Nama wajib diisi.',
                'name.max' => 'Nama maksimal 255 karakter.',
            
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
            
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
            
                'photo.required' => 'Foto wajib diisi.',
                'photo.image' => 'File foto harus berupa gambar.',
                'photo.mimes' => 'Foto hanya boleh berformat JPG, JPEG, atau PNG.',
                'photo.max' => 'Ukuran foto maksimal 2MB.',
            
                'role.required' => 'Role wajib diisi.',
                'role.in' => 'Role hanya boleh customer atau admin.',
            
                'status.required' => 'Status wajib diisi.',
                'status.in' => 'Status hanya boleh active atau inactive.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $photo = null;
            if($request->hasFile('photo')){
                $photoPath = $request->file('photo')->store('photoProfile','public');
            }

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
                'photo'=>$photoPath,
                'role'=>$request->role,
                'status'=>$request->status,
            ]);

            return response()->json([
                'message'=>'User rigistered Successfully',
                'user'=>$user,
            ],201);
        }catch(Exception $e){
            return response()->json([
                'message'=>'failed to register',
                'error'=>$e->getMessage(),
            ],500);
        }
    }

    public function historyOrderUser($id){
        try {
            $user = user::find($id);
            if(!$user){
                return response()->json([
                    'message'=>'User tidak ditemukan'
                ],404);
            }

            $orders = [];
            $error   = null;

            try{
                // Batasi timeout agar tidak nunggu terlalu lama
                $response = Http::timeout(2)->get("http://nginx-order/api/order/by-user/{$id}");

                if ($response->successful()) {
                    $orders = $response->json('data'); // array order
                }else{
                    $error = "Maaf sistem order belum aktif";
                }

            }catch(\Throwable $e){
                
                $orders = [];
                // Kalau koneksi gagal atau timeout
                $error = 'Mohon maaf, layanan order sedang tidak tersedia. Silakan coba lagi nanti.';
            }
            
        // Ambil data order
        // $data = $response->json();
        // $orders = $data['data'];  // Ambil bagian data yang berisi order

        return response()->json([
            'message' => 'Berhasil ambil data order by User',
            'user' => $user,
            'data' => $orders,
        ], 201);

        // return Inertia::render('Karyawan/OrderDetail', [
        //     'data' => $orders,
        //     'user_id' => intval($id),
        //     'error' => $error
        // ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Gagal mengambil data history order',
                'error' => $e->getMessage(),
            ],500);
        }
    }

    public function getUserByIdHasura(Request $request)
{
    $id = $request->input('id');

    $user = User::find($id);

    return response()->json([
        'id' => $user->id,
        'nama' => $user->nama,
        'email' => $user->email,
    ]);
}


}
