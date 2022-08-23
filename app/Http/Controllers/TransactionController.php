<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      // QUERY yang diguankan untuk mengambil data transaksi yang paling baru
      $transaction = Transaction::orderBy('time', 'DESC')->get();
      $response = [
         'message' => 'List data transaksi order berdasarkan waktu',
         'data' => $transaction
      ];

      return response()->json($response, Response::HTTP_OK);
      // akan mengembalikan data bertipe json dengan status 200
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'title' => ['required'],
         'amount' => ['required', 'numeric'],
         'type' => ['required', 'in:expense,revenue'] //pada :in tidak boleh ada spacing, jika ada spacing akan error
      ]);

      // jika salah akan menampilkan pesan errornya
      if ($validator->fails()) {
         return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      // jika berhasil
      try {
         // simpan data
         $transaction = Transaction::create($request->all()); //mengambil semua data request
         $response = [
            'message' => 'Transaction Created!',
            'data' => $transaction
         ];

         return response()->json($response, Response::HTTP_CREATED);
         //mengirim response dengan data json dan membuat statusnya HTTP Created atau berkode 201
      } catch (QueryException $e) {
         //jika gagal
         return response()->json([
            // menampilkan pesan error berserta errornya
            'message' => 'Failed' . $e->errorInfo
         ]);
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
