<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        // mengmabil semua data barang
        $barang = Barang::latest()->paginate(5);

        return new BarangResource(true, 'List data barang', $barang);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string',
            'kategori_barang' => 'required|in:Elektronik,Pakaian,Makanan,Lainnya',
            'jumlah_barang' => 'required|integer|min:1', 
            'harga_per_unit' => 'required|numeric|min:1', 
            'tanggal_masuk' => 'required|date|before_or_equal:today',
        ]);

        // jika validasi gagal
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // menyimpan ke database
        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->kategori_barang = $request->kategori_barang;
        $barang->jumlah_barang = $request->jumlah_barang;
        $barang->harga_per_unit = $request->harga_per_unit;
        $barang->tanggal_masuk = $request->tanggal_masuk;
        $barang->save();

        // mengembalikan response
        return new BarangResource(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }

    public function show($id)
    {
        $barang = Barang::find($id);

        return new BarangResource(true, 'Detail data barang!', $barang);
    }

    public function update(Request $request, $id)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::find($id);
    
        // Jika barang tidak ditemukan
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data Barang Tidak Ditemukan',
            ], 404);
        }
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'nullable|string', 
            'kategori_barang' => 'nullable|in:Elektronik,Pakaian,Makanan,Lainnya',
            'jumlah_barang' => 'nullable|integer|min:1',
            'harga_per_unit' => 'nullable|numeric|min:1', 
            'tanggal_masuk' => 'nullable|date|before_or_equal:today',
        ]);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // proses Update data
        $barang->nama_barang = $request->nama_barang ?? $barang->nama_barang;
        $barang->kategori_barang = $request->kategori_barang ?? $barang->kategori_barang;
        $barang->jumlah_barang = $request->jumlah_barang ?? $barang->jumlah_barang;
        $barang->harga_per_unit = $request->harga_per_unit ?? $barang->harga_per_unit;
        $barang->tanggal_masuk = $request->tanggal_masuk ?? $barang->tanggal_masuk;
        $barang->save();
    
        // Mengembalikan response
        return new BarangResource(true, 'Data Barang Berhasil Diubah!', $barang);
    }
    
    public function destroy($id)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::find($id);

        // Jika barang tidak ditemukan
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data Barang Tidak Ditemukan',
            ], 404);
        }

        // Hapus barang
        $barang->delete();

        // Mengembalikan response
        return new BarangResource(true, 'Data Barang Berhasil Dihapus!', null);
    }

}
