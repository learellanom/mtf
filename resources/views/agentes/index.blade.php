@extends('adminlte::page')
@section('title', 'Estadisticas por agentes')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Agente',
    'Cliente',
    'Monto Transaccion',
    'Fecha Transaccion',
    'Wallet',
    'Transaccion',
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];




$btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
$btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
$btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

$config = [
    'data' => [
        [22, '07-03-2023', 'John Bender',    '4,00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [19, '07-03-2023', 'Sophia Clemens', '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        [3,  '07-03-2023', 'Peter Sousa',    '4.00', '500.00', '501.00', '2%', '503.00', '504.00', '', '', '505.00', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    ],
    'order' => [[1, 'asc']],
    'columns' => [null, null, null, null, null, null, null, null, null, null, null, null, ['orderable' => false]]
];




@endphp

<br>
<br>
<h1 class="text-center text-dark font-weight-bold">Movientos por Agente</h1>
<br>
<br>
{{-- Disabled --}}
<!-- <x-adminlte-button label="Añadir" theme="dark" /> -->

<div class="container">
    <div class="row col-12">
        <div class ="col-12 col-sm-3">
<<<<<<< HEAD
            <x-adminlte-select2 id="userole"
                                name="optionsUsers" 
                                igroup-size="sm" 
=======
            <x-adminlte-select2 name="optionsUsers"
                                igroup-size="sm"
>>>>>>> 8c47733b5470d3d83e6f6af613771ec7b7410b26
                                label-class="text-lightblue"
                                data-placeholder="Select an option..."
                                style="height:45px;"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>
                <!-- <x-adminlte-options :options="['Car', 'Truck', 'Motorcycle']" empty-option/> -->
                <x-adminlte-options :options="$userole" empty-option="Selecciona un Agente.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-3">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>
    </div>
</div>

<br>
<br>


{{-- Minimal example / fill data using the component slot --}}
<!-- <x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable> -->

{{-- Compressed with style options / fill data using the plugin config --}}
<!-- <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark" :config="$config"
    striped hoverable bordered compressed/> -->

<x-adminlte-datatable id="table3" :heads="$heads">
    @foreach($Transacciones as $row)
        <tr>
            <td>{!! $row->AgenteName !!}</td>
            <td>{!! $row->ClientName !!}</td>
            <td>{!! $row->Monto !!}</td>
<<<<<<< HEAD
            <td>{!! $row->FechaTransaccion !!}</td>            
            <td>{!! $row->WalletName !!}</td> 
            <td>{!! $row->TipoTransaccion !!}</td>                          

=======
            <td>{!! $row->FechaTransaccion !!}</td>
            <td>{!! $row->WalletName !!}</td>
            <td>{!! $row->TipoTransaccion !!}</td>
<!--
            <td class="text-center"><a class="btn btn-primary" href=""><i class='fas fa-edit'></i></a></td> -->
>>>>>>> 8c47733b5470d3d83e6f6af613771ec7b7410b26
            <td class="text-center">
                <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>


    
@push('js')
    <script>
        $(() => {
            
            $('#userole').on('change', function (){
                 alert('iii' +  $('#userole').val());
            });

        })
    </script>
@endpush
@endsection
