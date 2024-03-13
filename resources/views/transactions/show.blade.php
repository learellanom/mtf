@extends('adminlte::page')

@section('title', 'Transacciones')
@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">VER MAS DE TRANSACCIÓN <i class="fas fa-exchange-alt"></i> </h1></a>
    <hr>

@stop

@php

    $myClass	        = new app\Http\Controllers\TransactionController;
    $myAdministrator    = $myClass->isAdministrator();

@endphp

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        @switch($transactions->type_transaction_id)
            @case(47)
                {{-- @include('transactions.show_material') --}}    
                @include('transactions.show_transaction')
                @break
            @case(48)
                @include('transactions.show_material_recepcion')
                @break
            @default
                @include('transactions.show_transaction')
                @break
        @endswitch

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

  @section('js')
  <script>
    /*
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    });
*/
  function apiUpdateStatus(id){
    //alert('apiUpdateStatus');
    //return;
    let data    = { id:  id };
    let token   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{route('transactions.update_status_api', $transactions->id )}}",{
        method:'POST',
        headers:{
            'Accept' : 'application/json',
            'Content-Type' : 'application/json',
            'X-CSRF-TOKEN': token
        }
    }).then(response => {
        return response.json()
    }).then(data =>{        
        if(data.success){
           // console.log('actualizo ->' + JSON.stringify(data));

           // $('#myBtnAnular').attr('disabled',true);
           if(data.result == "anulada"){

                $myColor = "btn btn-xl text-danger mx-1 shadow text-center";

                $('#myBtnAnular').removeClass("btn btn-xl text-success mx-1 shadow text-center");
                $('#myBtnAnular').addClass("btn btn-xl text-danger mx-1 shadow text-center");

                $('#myBadge').removeClass('badge badge-success');
                $('#myBadge').addClass('badge badge-danger');
                $('#myBadge').text('Anulada');

                $('#myIcon').removeClass('fa fa-lg fa-fw fas fa-check');
                $('#myIcon').addClass('fa fa-lg fa-fw fas fa-times');

                $('#myText').text('Activar');

                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Transaccion anulada satisfactoriamente',
                        showConfirmButton: true
                    }).then( function () {
                            window.location.href = "{{redirect()->getUrlGenerator()->previous()}}";
                        }
                    );  
                

        
           }else if(data.result == "activo"){

                $('#myBtnAnular').removeClass("btn btn-xl text-danger mx-1 shadow text-center");
                $('#myBtnAnular').addClass("btn btn-xl text-success mx-1 shadow text-center");

                $('#myBadge').removeClass('badge badge-danger');
                $('#myBadge').addClass('badge badge-success');
                $('#myBadge').text('Activo');      
              
                $('#myIcon').removeClass('fa fa-lg fa-fw fas fa-times');
                $('#myIcon').addClass('fa fa-lg fa-fw fas fa-check');

                $('#myText').text('Anular');

                Swal.fire({
                    position: 'center',
                    title: 'Transaccion Activada satisfactoriamente',
                    type: 'success',
                    showConfirmButton: true
                }).then( function (){
                        window.location.href = "{{redirect()->getUrlGenerator()->previous()}}";
                    }
                );
           }
        }else{
            // console.log('no actualizo ->');
        }

    }).catch(error => console.error( 'Error en Fetch -> ' + error));
  }


    function editTransaction(){
        
        let myVar               = "{{ $transactions->pay_number }}";
        let myStatus            = "{{$transactions->status}}";
        let myTransferNumber    = "{{$transactions->transfer_number}}";

        if (myStatus == "Anulado"){
            Swal.fire({
                position: 'center', 
                title: 'No se puede editar una transaccion Anulada',
                type: 'error',                
                showConfirmButton: true
            });            
            return;
        }

        if (myVar != ""){
            
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar un Pago del proveedor , debe anularse',
                showConfirmButton: true
            });             
            return;    
        }

        if (myTransferNumber != ""){
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'No se puede editar una Transferencia o Cobros entre Cajas, debe anularse',
                showConfirmButton: true
            });             
            return;    
        }


        let myRoute = "";

        myRoute = "{{route('transactions.edit2', $transactions->id)}}";
        location.href = myRoute;
        
    }



  </script>
  @endsection
