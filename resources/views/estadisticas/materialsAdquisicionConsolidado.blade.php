@extends('adminlte::page')
@section('title', 'Adquisicion Consolidado')
@section('content')
{{-- Setup data for datatables --}}

@php

$heads = [
    'Nro',
    'Caja',    
    'Grupo',    
    'Fecha',
    'Material',

    'Precio/U',
    'Cantidad',
    'Monto',

    'Saldo Total',
    'Cierre Total',

    
    'Nro Recepcion',
    'Recepcion Fecha',
    'Recepcion Cantidad',
    'Recepcion Cantidad Asignado',
    'Recepcion Material Total',

    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
    'columns' => [null, null, null, null, ['orderable' => false]]
];


$config1 =
[
    "allowClear" => true,
];

$config2 =
[
    "allowClear" => true,
];

$config3 = [
    "locale" => ["format" => "DD-MM-YYYY"],
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

@endphp

<script>


</script>
<br>
<br>
<h1 class="text-center text-dark font-weight-bold text-uppercase">{{ __('Adquisicion Consolidado') }} <i class="fas fa-w fa-box"></i></h1>
<br>
<br>
{{-- Disabled --}}

<div class="container-left">
    <div class="row col-12 d-flex">

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="wallet"
                                name="optionsCliente"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Wallet ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-box"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$wallet" empty-option="Selecciona un Wallet.."/>
            </x-adminlte-select2>
        </div>

        <div class ="col-12 col-sm-2">
            <x-adminlte-select2 id="group"
                                name="optionsGroup"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Grupo ..."
                                :config="$config2"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <i class="fas fa-user-tie"></i>
                    </div>
                </x-slot>

                <x-adminlte-options :options="$group" empty-option="Selecciona un Grupo.."/>
            </x-adminlte-select2>
        </div>


        <div class ="col-12 col-sm-2">
            <x-adminlte-date-range name="drCustomRanges" enable-default-ranges="Last 30 Days" style="height: 30px;" :config="$config3">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-date-range>
        </div>

        <div class ="col-lg-2">
            <x-adminlte-select2 id="type_material_id"
                                name="type_material_id"
                                igroup-size="sm"
                                label-class="text-lightblue"
                                data-placeholder="Material ..."
                                :config="$config1"
                                >
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-gradient-dark">
                        <!-- <i class="fas fa-car-side"></i> -->
                        <!-- <i class="fas fa-user-tie"></i> -->
                        <i class="fas fa-solid fa-dollar-sign"></i>                        
                    </div>
                    
                </x-slot>

                <x-adminlte-options :options="$type_material" empty-option="Selecciona un material.."/>

            </x-adminlte-select2>
            </div>

    </div>

</div>


<br>
<br>



<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title text-uppercase font-weight-bold">{{ __('Estadisticas| Adquisicion Consolidado') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-datatable id="table3" :heads="$heads" class="table table-bordered table-responsive-lg" hoverable with-buttons>
                            @foreach($adquisiciones as $row)
                                <tr>
                                    <td>{!! $row->Id !!}</td>                                    
                                    <td>{!! $row->WalletName !!}</td>
                                    <td>{!! $row->GroupName !!}</td>
                                    <td>{!! $row->TransactionDate !!}</td>
                                    <td>{!! $row->TypeMaterialName !!}</td>

                                    <td>{!! number_format($row->MaterialPrice,2) !!}</td>
                                    <td>{!! number_format($row->MaterialAmount) !!}</td>
                                    <td>{!! number_format($row->MaterialAmountTotal,2) !!}</td>

                                    <td>{!! number_format($row->AdquisicionCierreAmount,2) !!}</td>
                                    <td>{!! number_format($row->AdquisicionCierreCant) !!}</td>


                                    <td>{!! $row->RecepcionId !!}</td>                                    
                                    <td>{!! $row->RecepcionTransactionDate !!}</td>


                                    <td class="text-right">{!! number_format($row->RecepcionMaterialAmount) !!}</td>
                                    <td class="text-right">{!! number_format($row->RecepcionMaterialAmount2) !!}</td>
                                    
                                    <td>{!! number_format($row->RecepcionBalance,2,",",".") !!}</td>

                                    <!-- 
                                    <td class="text-center">
                                        <button class="btn btn-xl text-teal mx-auto shadow" title="Detalles">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </button>
                                    </td> 
                                    -->

                                    <!--
                                    <td class="text-center">
                                        <a
                                            href="#"
                                            title="Detalles"
                                            class="btn btn-xl text-primary mx-1 shadow text-center"
                                            onClick="theRoute2({{0}}, {{0}}, {{$row->Id}})"
                                        >
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                    -->
                                    <td>

                                        <a href="{{ route('transactions.show', $row->Id) }}"

                                            class="btn btn-xl text-dark mx-1 shadow text-center">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>

                                    <td>

                                        <a href="{{ route('transactions.show', $row->RecepcionId) }}"

                                            class="btn btn-xl text-dark mx-1 shadow text-center">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>


    const miWallet          = {!! $myWallet !!};
    const miGroup           = {!! $myGroup !!};
    const miType_material   = {!! $myType_material!!};
    
    BuscaMyElement('wallet',miWallet);
    BuscaMyElement('group',miGroup);
    BuscaMyElement('type_material_id',miType_material);

    
    $(() => {

        InicializaFechas();
        // BuscaFechas();
        BuscaFechasBlade();
        
        $('#wallet, #group, #type_material_id, #drCustomRanges').on('change', function (){

            const wallet        = $('#wallet').val();
            const group         = $('#group').val();
            const type_material = $('#type_material_id').val();

            let myFechaDesde, myFechaHasta;
            
            myFechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(3,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(0,2)
                            ;

            myFechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(16,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(13,2)
                            ;

            theRoute(wallet,group,myFechaDesde,myFechaHasta, type_material);

        }).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
        });        
        

        $('#drCustomRanges').on('change', function () {

            const wallet        = $('#wallet').val();
            const grupo         = $('#grupo').val();
            const type_material = $('#type_material_id').val();

            // alert('ggggg ' + $('#drCustomRanges').val());
            let myFechaDesde, myFechaHasta;

            myFechaDesde =  ($('#drCustomRanges').val()).substr(6,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(3,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(0,2)
                            ;

            myFechaHasta =  ($('#drCustomRanges').val()).substr(19,4) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(16,2) +
                            '-' +
                            ($('#drCustomRanges').val()).substr(13,2)
                            ;

            //alert('Fecha Desde ' + myFechaDesde + 'Fecha Hasta ' + myFechaHasta);

            
            theRoute(wallet, grupo, myFechaDesde,myFechaHasta,type_material);
        });



    })

    function theRoute(wallet = 0, group = 0, fechaDesde = 0, fechaHasta = 0, type_material = 0){

        // alert('leam - cambio');

        if (wallet  === "") wallet  = 0;
        if (group  === "") group  = 0;
        if (type_material  === "") type_material  = 0;

        let myRoute = "";
            myRoute = "{{ route('materialsAdquisicionConsolidado', ['wallet' => 'wallet2',  'group' => 'group2', 'type_material' => 'type_material2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2']) }}";
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('fechaDesde2',fechaDesde);
            myRoute = myRoute.replace('fechaHasta2',fechaHasta);
            myRoute = myRoute.replace('group2',group);
            myRoute = myRoute.replace('type_material2',type_material);
            myRoute = myRoute.replaceAll('amp;','');
        // console.log(myRoute);
         // alert(myRoute);
        location.href = myRoute;

    }

    function theRoute2(usuario = 0, grupo = 0, wallet = 0, typeTransactions = 0){

        if (usuario === "") usuario = 0;
        if (grupo   === "") grupo = 0;
        if (wallet  === "") wallet  = 0;

        let myFechaDesde, myFechaHasta;

        
        let myFechaDesdeCompara =  "{{ $myFechaDesde }}";
        if (myFechaDesdeCompara == "2001-01-01"){
            myFechaDesde = "{{ $myFechaDesde }}";
            myFechaHasta = "{{ $myFechaHasta }}";
        }else{
            myFechaDesde = $('#drCustomRanges').data('daterangepicker').startDate.format('YYYY-MM-DD');
            myFechaHasta = $('#drCustomRanges').data('daterangepicker').endDate.format('YYYY-MM-DD');
        }
        //  alert('leam - fecha desde -> ' + myFechaDesde + ' fecha hasta ->' + myFechaHasta);

        let coin = $('#coin').val() ? $('#coin').val() : 1;

        let myRoute = "";
            myRoute = "{{ route('estadisticasDetalle', ['usuario' => 'usuario2', 'grupo' => 'grupo2', 'wallet' => 'wallet2', 'typeTransactions' => 'typeTransactions2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'coin' => 'coin2']) }}";
            myRoute = myRoute.replace('grupo2',grupo);
            myRoute = myRoute.replace('usuario2',usuario);
            myRoute = myRoute.replace('wallet2',wallet);
            myRoute = myRoute.replace('typeTransactions2',typeTransactions);            
            myRoute = myRoute.replace('fechaDesde2',myFechaDesde);
            myRoute = myRoute.replace('fechaHasta2',myFechaHasta);
            myRoute = myRoute.replace('coin2',coin);
            myRoute = myRoute.replaceAll('amp;','');
        // console.log(myRoute);
         alert(myRoute);
        location.href = myRoute;

    }



    function BuscaFechas(FechaDesde = 0, FechaHasta = 0){

        myLocation  = window.location.toString();

        myArray     = myLocation.split("/");

        if (myArray.length > 4){
            FechaDesde = myArray[5];
            FechaHasta = myArray[6];
        }else{
            FechaDesde = 0;
            FechaHasta = 0;       
        }

        // alert("fecha desde -> " + FechaDesde + " Fecha hasta -> " + FechaHasta);

        if (FechaDesde == 0) return;


        let myFechaDesde, myFechaHasta, myFecha;

        myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
        myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

        myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);

    }




    function InicializaFechas(){
        // $('#drCustomRanges').data('daterangepicker').setStartDate('01-01-2001');

    }


    function BuscaFechasBlade(){

        //console.log('leam - myFechaDesde ->' + "{{ $myFechaDesde }}");
        //console.log('leam - myFechaHasta ->' + "{{ $myFechaHasta }}");
        // alert();
        let myFechaDesdeCompara = "{{ $myFechaDesde }}";
        if (myFechaDesdeCompara == "2001-01-01"){
            //console.log('leam - salio por aqui');
            return;
        }

        let myFechaAnio  = {{ substr($myFechaDesde,0,4) }};
        let myFechaMes   = {{ substr($myFechaDesde,5,2) }};
        let myFechaDia   = {{ substr($myFechaDesde,8,2) }};

        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaDesde2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio)

        myFechaAnio  = {{ substr($myFechaHasta,0,4) }};
        myFechaMes   = {{ substr($myFechaHasta,5,2) }};
        myFechaDia   = {{ substr($myFechaHasta,8,2) }};

        myFechaMes       = myFechaMes.toString().length == 1 ? '0' + myFechaMes.toString() : myFechaMes;
        myFechaDia       = myFechaDia.toString().length == 1 ? '0' + myFechaDia.toString() : myFechaDia;

        let myFechaHasta2 = myFechaDia.toString().concat('-', myFechaMes, '-', myFechaAnio);


        //console.log('myFechaDesde2 ->' + myFechaDesde2);
        //console.log('myFechaHasta2 ->' + myFechaHasta2);

        $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde2);
        $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta2);

    }


    function BuscaMyElement(myControl = "", myElement = ""){
        // alert("BuscaTypeMaterial - myTypeMaterial -> " + myTypeMaterial);

        let mySelect = myControl;
        let myValue  = myElement;

        // console.log('leam - busca en select ->' + mySelect);
        // console.log('leam - busca myValue   ->' + myValue);

        $('#' + mySelect).each( function(index, element){
            // alert ("BuscaMaterial -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
            $(this).children("option").each(function(){
                if ($(this).val() === myValue.toString()){
                    // alert('Busca Material - encontro');
                    // console.log('Busca Material - encontro');
                    $("#" + mySelect + " option[value="+ myValue +"]").attr("selected",true);
                }
                //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
            });
        });
        //
    }

</script>

@endsection
