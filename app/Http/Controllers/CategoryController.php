<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Category::all();
        $data = Category::get();
        if($data){
            $response = [
                'message'		=> 'Tampilan Pembayaran',
                'data' 		    => $data,
            ];

            // echo(response()->json(data));
            return response()->json($response, 200);
        }
        $response = [
            'message'		=> 'An Error Occured'
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $category = new category();
        // $category->gambar_category = $request->gambar_category;
        // $category->nama_category = $request->nama_category;
        // if ($category->save()) {
        //     return ["status" => "Berhasil Menyimpan Category"];
        // } else {
        //     return ["status" => "Gagal Menyimpan Category"];
        // }
        {
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && $request->isJson()
        ) {
            $dataReq = $request->json()->all();
            $Arryrequest = json_decode(json_encode($dataReq), true);
    
        }else {
            $Arryrequest["gambar_category"] =$request->input("gambar_category");
            $Arryrequest["nama_category"] =$request->input("nama_category");
        }
        // $this->validate($request, [
    
        //     'nama_provinsi'   => 'required',
        //     'KodeDepdagri'   => 'required',
        //     'IsActive'   => 'required',
        // ]);
    
        try {
            DB::beginTransaction();
            
            $p = new Category([
                'gambar_category' => $Arryrequest['gambar_category'],
                'nama_category' => $Arryrequest['nama_category'],
            ]);
    
            $p->save();
            DB::commit();
            
            $response = [
                'message'        => 'Success Menambahkan Category',
                'data'         => $p
            ];
    
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $response = [
                'message'        => 'Transaction DB Error',
                'data'      => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::where($id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
