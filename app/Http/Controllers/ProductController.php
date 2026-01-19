<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::paginate(10);
        return view('admin.page.product',[
            'name'  => "Product",
            'title' => 'Admin Product',
            'data'  => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addModal()
    {
        return view('admin.modal.addmodal',[
            'title' => 'Tambah Data Product',
            'sku'   => 'BRG'.rand(10000, 99999),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = new Product();
        $data->sku           = $request->sku;
        $data->nama_product  = $request->nama;
        $data->deskripsi     = $request->deskripsi;
        // sunah start 1
        $data->type          = $request->type;
        $data->kategory      = $request->kategori;
        // sunah end 1
        $data->harga         = $request->harga;
        $data->quantity      = $request->quantity;
        $data->quantity_out  = 0;
        // sunah start 2
        $data->discount      = 10 / 100;
        // sunah end 2
        $data->is_active     = 1;
        
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        } else {
            $data->foto = 'default.png'; // siapkan default.png di folder public/storage/product
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('product');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = product::findOrFail($id);

        return view(
            'admin.modal.editModal',
            [
                'title' => 'Edit data product',
                'data'  => $data,
            ]
        )->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Product $product)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $data = Product::findOrFail($id);

        if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        } else {
            $filename = $request->foto;
        }

        $field = [
            'sku'            => $request->sku,
            'nama_product'   => $request->nama,
            'deskripsi'      => $request->deskripsi,
            'type'           => $request->type,
            'kategory'       => $request->kategori,
            'harga'          => $request->harga,
            'quantity'       => $request->quantity,
            // sunah 2
            'discount'       => 10 / 100,
            'is_active'      => 1,
            'foto'           => $filename,
        ];

        $data::where('id',$id)->update($field);
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->route('product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = product::findOrFail($id);
        $product->delete();

        $json = [
            'success' => "Data berhasil dihapus"
        ];

        echo json_encode($json);
    }

}
