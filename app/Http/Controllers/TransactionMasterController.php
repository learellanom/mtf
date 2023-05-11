<?php

namespace App\Http\Controllers;

use App\Models\Transaction_master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type_coin;
use App\Models\Type_transaction;
use App\Models\Wallet;
use App\Models\Group;
use App\Models\Image;
use App\Models\User;
use Database\Factories\TransactionFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Nette\Utils\Finder;
use Carbon\Carbon;

class TransactionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transferencia = Transaction_master::all();
        return view('transactions_master.index', compact('transferencia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Transaction_master $transaction)
    {
        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::whereIn('type_transaction', ['Transacciones', 'Efectivo'])->pluck('name', 'id');
        $wallet = Wallet::whereNotIn('id', [3])->pluck('name', 'id');
        $group = Group::pluck('name', 'id');
        $user = User::pluck('name', 'id');
        $fecha = Carbon::now();

        return view('transactions_master.create', compact('type_coin', 'type_transaction', 'wallet', 'group', 'user', 'transaction', 'fecha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = Transaction_master::create($request->all());
        $files = [];
       if($request->hasFile('file')){
        foreach($request->file('file') as $file)
        {

            $url = Storage::put('public/Transactions_Master/'.$transaction->id, $file);

            $files= new Image();
            $files->file = $files;


            $transaction->image()->create([
                'url' => $url
            ]);
            //return response()->json(['url' => $url]);
          }
        }

        flash()->addSuccess('Movimiento guardado', 'Transacción Master', ['timeOut' => 3000]);

        return Redirect::route('transactions_master.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($transaction_master)
    {
        $transactions = Transaction_master::find($transaction_master);

        $imagen = Transaction_master::findOrFail($transaction_master)->image;
        //$image = $transactions->image()->find($transactions);
        //$image = Transaction::find($transactions)

        $type_coin = Type_coin::pluck('name', 'id');
        $type_transaction = Type_transaction::pluck('name', 'id');
        $wallet = Wallet::pluck('name', 'id');
        $group = Group::pluck('name', 'id');



        $user = User::pluck('name', 'id');



        return view('transactions_master.edit', compact('transactions', 'imagen', 'type_coin', 'type_transaction', 'wallet', 'group', 'user'));
    }

    public function show($transaction)
    {
        $transactions = Transaction_master::find($transaction);
        if($transactions->group == null){
            return view('transactions_master.show', compact('transactions'));
        }
        else{
            $transactiones = Transaction_master::whereIn('group_id', [$transactions->group->id])->whereNotIn('id', [$transaction])->latest('id')->paginate(3);
            return view('transactions_master.show', compact('transactions', 'transactiones'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $transaction_master)
    {
        Transaction_master::find($transaction_master)->update($request->all());
        $movimientos = Transaction_master::findOrFail($transaction_master);
        $file = [];

        if($request->file('file')){
           foreach($request->file('file') as $files){
              $url = Storage::put('public/Transactions_Master/'.$transaction_master, $files);



         if($request->file('file')){

             $file= new Image();
             $file->file = $file;

              $movimientos->image()->create([
                'url' => $url
            ]);

         }

        else{

            $files= new Image();
            $files->file = $files;

            $movimientos->image()->create([
                'url' => $url
            ]);

          }

        }
      }

        flash()->addInfo('Transacción modificada..', 'Transacción <strong># ' . $movimientos . '</strong>', ['timeOut' => 3000]);
        return Redirect::route('transactions_master.index');
    }

    /**
     * Remove the specified resource from storage.
     */

     public function update_status(Request $request, $transaction)
     {
         $transactions = Transaction_Master::find($transaction);

         if($transactions->status == 'Activo'){
         Transaction_Master::findOrFail($transaction)->update([
             'status' => 'Anulado',
         ]);
            return Redirect::route('transactions_master.index')->with('error', 'Transacción Master anulada  <strong># '. $transaction . '</strong>');
         }
         elseif($transactions->status == 'Anulado'){
             Transaction_Master::findOrFail($transaction)->update([
                 'status' => 'Activo',
             ]);
             return Redirect::route('transactions_master.index')->with('success', 'Transacción Master activada  <strong># '. $transaction . '</strong>');
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
