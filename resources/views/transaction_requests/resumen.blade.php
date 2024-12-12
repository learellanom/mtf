@extends('adminlte::page')

@section('title', 'Tipo de Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Resumen') }} <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')



{{-- Compressed with style options / fill data using the plugin config --}}
<style>
                    .myTr {
                        cursor: pointer;
                    }
                    .myTr:hover{
                        background-color: #D7DBDD  !important;
                    }
                </style>
<div class="d-flex justify-content-center">

        <div class="card col-md-4">
            <div class="card-header">
                {{-- <h3 class="card-title font-weight-bold">{{ __('Resumen') }} <i class="fab fa-bitcoin"></i></h3> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 justify-content-center text-center">
                        <h4 class="font-weight-bold">{{ __('Solicitudes') }} <i class="fab fa-bitcoin"></i></h4>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="moneda">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Nro</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                                @php
                                    $nroSolicitudes = 0;
                                @endphp

                                @foreach($Transaction_request as $item)
                                    @if($item->type_request == 1)
                                        @php
                                            $nroSolicitudes++;
                                        @endphp
                                        <tr class="myTr" onClick="theRoute({{$item->type_request}},'{{$item->status}}',{{$group->GroupID}})">
                                            <td>{!! $item->status!!}</td>
                                            <td>{!! $item->cantidad!!}</td>
                                            <td>{!! number_format($item->monto,2)!!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if($nroSolicitudes == 0)
                                    <tr class="mt-5 mb-5">
                                        <td  class="justify-content-center text-center" colspan=3>Sin operaciones registradas</td>                        
                                    </tr>
                                @endif
                            
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <hr class="bg-dark escoder mt-5 mb-5" style="height:1px;"> 
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-12 justify-content-center text-center">
                        <h4 class="font-weight-bold">{{ __('Notificaciones') }} <i class="fab fa-bitcoin"></i></h4>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="moneda">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Nro</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            @php
                                $nroSolicitudes = 0;
                            @endphp

                            @foreach($Transaction_request as $item)
                                @if($item->type_request == 2)      
                                        @php
                                            $nroSolicitudes++;
                                        @endphp                                                          
                                    <tr class="myTr" onClick="theRoute({{$item->type_request}},'{{$item->status}}',{{$group->GroupID}})">
                                        <td>{!! $item->status!!}</td>
                                        <td>{!! $item->cantidad!!}</td>
                                        <td>{!! number_format($item->monto,2)!!}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($nroSolicitudes == 0)
                                <tr class="mt-5 mb-5">
                                    <td  class="justify-content-center text-center" colspan=3>Sin operaciones registradas</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>



            </div>
        </div>
    
</div>

@endsection
@section('js')
<script type="text/javascript">
$(document).ready( function () {
    $('#monedaa').DataTable({

        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });

} );

function theRoute(type_request = null , status = null, grupo = null){

    // transaction_requests_index

    // alert("este es el item -> " + item);

    let myRoute = "";
            myRoute = "{{ route('transaction_requests_index', ['type_request' => 'type_request2', 'status' => 'status2', 'grupo' => 'grupo2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('type_request2',type_request);
            myRoute = myRoute.replace('status2',status);
            myRoute = myRoute.replaceAll('amp;','');
        // console.log(myRoute);
         // alert(myRoute);
        location.href = myRoute;

}

</script>
@endsection
