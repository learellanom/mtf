<?php

namespace App\Http\Controllers;

use App\Models\Transaction_supplier;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\User;
use App\Models\Wallet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Storetransaction_supplierRequest;
use App\Http\Requests\Updatetransaction_supplierRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Nette\Utils\Finder;
use Carbon\Carbon;

class TransactionSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferencia = Transaction_Supplier::all();
        return view('transactions_supplier.index', compact('transferencia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Transacciones', 'Efectivo'])->pluck('name', 'id');
        $proveedor = Supplier::pluck('name', 'id');
        $wallet = Wallet::whereNotIn('id', [3])->pluck('name', 'id');
        $user = User::pluck('name', 'id');
        $fecha = Carbon::now();

        return view('transactions_supplier.create', compact('type_coin', 'type_transaction','proveedor', 'user', 'fecha', 'wallet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = Transaction_Supplier::create($request->all());
        $files = [];
       if($request->hasFile('file')){
        foreach($request->file('file') as $file)
        {

            $url = Storage::put('public/Transactions_Proveedores/'.$transaction->id, $file);

            $files= new Image();
            $files->file = $files;


            $transaction->image()->create([
                'url' => $url
            ]);
            //return response()->json(['url' => $url]);
          }
        }

        flash()->addSuccess('Transacción guardada', 'Transacción Proveedores', ['timeOut' => 3000]);

        return Redirect::route('transactions_supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($transaction)
    {
        $transactions = Transaction_Supplier::find($transaction);
        if($transactions->wallet == null){
            return view('transactions_supplier.show', compact('transactions'));
        }
        else{
            $transactiones = Transaction_Supplier::whereIn('wallet_id', [$transactions->wallet->id])->whereNotIn('id', [$transaction])->latest('id')->paginate(3);
            return view('transactions_supplier.show', compact('transactions', 'transactiones'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaction_supplier $transaction_supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetransaction_supplierRequest $request, transaction_supplier $transaction_supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction_supplier $transaction_supplier)
    {
        //
    }

    public function update_status(Request $request, $transaction)
     {
         $transactions = Transaction_Supplier::find($transaction);

         if($transactions->status == 'Activo'){
            Transaction_Supplier::findOrFail($transaction)->update([
             'status' => 'Anulado',
         ]);
            return Redirect::route('transactions_supplier.index')->with('error', 'Transacción a proveedor anulada  <strong># '. $transaction . '</strong>');
         }
         elseif($transactions->status == 'Anulado'){
            Transaction_Supplier::findOrFail($transaction)->update([
                 'status' => 'Activo',
             ]);
             return Redirect::route('transactions_supplier.index')->with('success', 'Transacción a proveedor activada  <strong># '. $transaction . '</strong>');
         }

     }


    public function destroyImg($transaction_master){



        $img=Image::whereId($transaction_master)->first();


        // Busca la imagen en base de datos
        if(!$img){
            return response()
                    ->json(['error'=>'Lo sentimos, la imagen no esta en nuetra base de datos.']);
        }
        // Comprobar imagen en archivos
        if(!Image::exists('/'.$img->url)){
            return response()
                    ->json(['error'=>'Lo sentimos, la imagen no está en la carpeta de transacciones']);
        }

        unlink(storage_path('app\\'.$img->url));


        $img->delete();

        flash()->addError('Imagen eliminada de la transacción numero '. '# '. $transaction_master, 'Transacción', ['timeOut' => 2000]);

        return true;


    }






}
