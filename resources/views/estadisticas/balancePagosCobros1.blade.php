@extends('adminlte::page')

@section('title', 'Balance ed Pagos y Corbros')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">{{ __('Balance de Pagos y Cobros por Grupo') }} <i class="fab fa-bitcoin"></i> </h1></a>

@stop
@php

$config1 =
[
    "allowClear" => true,
];

$config3 = [
    "locale" => ["format" => "DD-MM-YYYY"],
    "allowClear" => true,
    "showDropdowns:" => "true",
];

$config4 = [
    "placeHolder" => "selecciona...",
    "allowClear" => true,
];

@endphp

@section('content')

{{-- Compressed with style options / fill data using the plugin config --}}
<input type="hidden" name="myGroup"         id="myGroup" value="">
<input type="hidden" name="myFechaDesde"    id="myFechaDesde" value="">
<input type="hidden" name="myFechaHasta"    id="myFechaHasta" value="">
<input type="hidden" name="myTypeCoin"      id="myTypeCoin" value="">

<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                {{-- <h3 class="card-title font-weight-bold">{{ __('Balance de Pagos y Cobros por Grupo') }} <i class="fab fa-bitcoin"></i></h3> --}}
                <div class="row">
                    {{--
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-gradient-light" bis_skin_checked="1">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <input class="form-control" type="text" name="myDateControl" id="myDateControl">
                        </div>
                    </div>
                    --}}
                    <div class="col-12 col-lg-3">
                        <x-adminlte-select2 
                            id="grupo"
                            name="optionsGroups"
                            label-class="text-lightblue"
                            data-placeholder="Seleccione Grupo"
                            :config="$config4"
                        >
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-light">
                                <i class="fas fa-box"></i>
                            </div>
                        </x-slot>
                        <x-adminlte-options :options="$grupo" empty-option="Grupo.."/>
                        </x-adminlte-select2>
                    </div>

                    <div class ="col-12 col-lg-3">
                        <x-adminlte-date-range
                            name="drCustomRanges"
                            enable-default-ranges="Last 30 Days"
                            
                            :config="$config3">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-light">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                            {{--
                            <x-slot name="appendSlot">
                                <x-adminlte-button 
                                    id="myDrClearButton"
                                    label="X" 
                                    icon="fas  fa-x"/>
                            </x-slot>
                            --}}
                        </x-adminlte-date-range>


                    </div>

                    <div class ="col-sm-3">
                        <x-adminlte-select2 id="coin"
                                            name="optionsCoin"
                                            igroup-size="sm"
                                            label-class="text-lightblue"
                                            data-placeholder="MonedaGrupo ..."
                                            :config="$config1"
                                            >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-dark">
                                    <!-- <i class="fas fa-car-side"></i> -->
                                    <!-- <i class="fas fa-user-tie"></i> -->
                                    <i class="fas fa-solid fa-dollar-sign"></i>                        
                                </div>
                                
                            </x-slot>

                            <x-adminlte-options :options="$Type_coin_balance" empty-option="Selecciona una moneda.."/>

                        </x-adminlte-select2>
                    </div>

                </div>
                
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-responsive-lg" id="moneda">
                            <thead>
                                <tr>                                
                                    <th>Id</th>
                                    <th>Grupo</th>
                                    <th>Saldo anterior Pagos</th>                                    
                                    <th>Monto Pagos</th>
                                    <th>Monto Cobrado</th>
                                    <th>Monto Deuda</th>
                                    
                                    <th class="text-center">Ver</th>
                                    
                                </tr>
                            </thead>
                            
                            @foreach($Transacciones as $item)
                                @php 
                                    $myAmountDeuda = 0;
                                    $myAmountDeuda  = ($item->monto_pago_anterior + $item->amount_total) - $item->monto_cobro;
                                    $myRowColor     = $myAmountDeuda  > 0 ? "red" : "black";
                                @endphp
                                <tr style="color: {{$myRowColor}}">

                                    <td>{!! $item->group_id!!}</td>
                                    <td>{!! $item->name!!}</td>
                                    {{-- <td>{!! $item->type_transaction_name!!}</td> --}}
                                    <td class="text-left">{!! number_format($item->monto_pago_anterior,2)!!}</td>
                                    <td class="text-left">{!! number_format($item->amount_total,2)!!}</td>
                                    <td class="text-left">{!! number_format($item->monto_cobro,2)!!}</td>
                                    <td class="text-left">{!! number_format($myAmountDeuda,2)!!}</td>
                                    
                                    <td class="text-center">
                                                                                                       
                                        <a class="btn btn-xl text-primary mx-1 shadow" href="{{ route('balancePagosCobrosGrupoFecha', ['group' => $item->group_id]) }}" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                    </td>
                                    
                                        
                                </tr>
                            @endforeach
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">


const miGrupo           = {!! $myGroup !!};

BuscaGrupo(miGrupo);
        
const myTypeCoinBalance = {!! $myTypeCoinBalance !!};
            
BuscaMoneda(myTypeCoinBalance);


$(document).ready( function () {




    
    const myFechaDesde = '{{$myFechaDesde}}';
    const myFechaHasta = '{{$myFechaHasta}}';

    //
    
    
    console.log('myFechaDesde -> ' + myFechaDesde);
    console.log('myFechaHasta -> ' + myFechaHasta);

    // InicializaFechas();

    BuscaFechas(myFechaDesde, myFechaHasta);


    $('#moneda').DataTable({

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
        'dom' : '<"row" <"col-12 col-md-6" B> <"col-12 col-md-6 text-align-right" f> >ti <"row" <"col-12 col-md-6" l> <"col-12 col-md-6" p>>',
        'buttons':[
            {
                extend:  'excel',
                exportOptions: { columns: [1, 2, 3,4,5] },
                text:    '<i class="fas fa-file-excel"></i>',
                title: `Balance de Pagos y Cobros`,
                titleAttr: 'Exportar Excel',
                className: 'btn btn-success',                     
                excelStyles: [
                    {
                        "template": ["title_medium", "gold_medium"]
                    },    
                ],                                                                      
            },
            {
                extend:  'pdfHtml5',
                exportOptions: { columns: [1, 2, 3,4,5] },
                text:    '<i class="fas fa-file-pdf"></i>',
                orientation: 'landscape',
                title: 'MTF | LISTA DE TRANSACIÓNES',
                titleAttr: 'Exportar PDF',
                className: 'btn btn-danger',
                defaultStyle: {
                    fontSize: 6
                },
            },
            {
                extend:  'print',
                exportOptions: { columns: [1, 2, 3,4,5] },
                text:    '<i class="fas fa-print"></i>',
                orientation: 'landscape',
                titleAttr: 'Capture de pantalla',
                className: 'btn btn-info'
            },
        ]       

    });


    $('#grupo').on('change', function (){

        const grupo         = $('#grupo').val()     == "" ? null : $('#grupo').val();

        $('#myGroup').val(grupo);

        theRoute(grupo);

        }).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

    $('#coin').on('change', function (){

        const coin         = $('#coin').val()     == "" ? null : $('#coin').val();

        $('#myTypeCoin').val(coin);

        theRoute(undefined, undefined,undefined,coin);

        }).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        // $('#drCustomRanges').daterangepicker({
        //     autoUpdateInput: true,
        //     locale: {
        //         cancelLabel: 'limpiar'
        //     }
        // });
        
    $('#drCustomRanges').on('change', function () {

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
        
        $('#myFechaDesde').val(myFechaDesde);
        $('#myFechaHasta').val(myFechaHasta);

        theRoute(null, myFechaDesde,myFechaHasta);

    })
    .on('cancel.daterangepicker', function(ev, picker) {
        // alert('ajua');
            // $(this).val('');
            // $(this).data('daterangepicker').setStartDate(moment());
            // $(this).data('daterangepicker').setEndDate(moment());
    });
    ;

    // $('#drCustomRanges').daterangepicker({
    $('#myDateControl').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Limpiar',
      },    
      alwaysShowCalendars: true,
      ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    })
    .on('change', function () {alert('cambia fecha')})
    .on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        // alert('cambia por aqui');


        let myFechaDesde, myFechaHasta;
        myFechaDesde =  picker.startDate.format('YYYY-MM-DD');
        myFechaHasta =  picker.endDate.format('YYYY-MM-DD');                        ;
        
        $('#myFechaDesde').val(myFechaDesde);
        $('#myFechaHasta').val(myFechaHasta);
        
        theRoute(null, myFechaDesde,myFechaHasta);

    }).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('#myFechaDesde').val('');
        $('#myFechaHasta').val('');

        theRoute(null, myFechaDesde,myFechaHasta);
    });





} );



function BuscaGrupo(miGrupo = ""){

    if (miGrupo == "" || miGrupo == 0 || miGrupo == null) return;

    $('#grupo').each( function(index, element){
        $(this).children("option").each(function(){
            if ($(this).val() === miGrupo.toString()){   
                $("#grupo option[value="+ miGrupo +"]").attr("selected",true);
            }
        });
    });

    $('#myGroup').val(miGrupo);

}

function toggleBotones(){
    $('#myBtnImprimir').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
    // $('#myBtnExcel').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
    // $('#myBtnPDF').prop('disabled') ? $('#myBtnImprimir').prop('disabled',false) : $('#myBtnImprimir').prop('disabled',true)
}

function BuscaMoneda(myTypeCoinBalance){
    // alert("BuscaMoneda - myTypeCoinBalance -> " + myTypeCoinBalance);

    $('#coin').each( function(index, element){
        //alert ("Buscagrupo -> " + $(this).val() + " text -> " + $(this).text()+ " y con index -> " + $(this).prop('selectedIndex'));
        $(this).children("option").each(function(){
            if ($(this).val() === myTypeCoinBalance.toString()){
                //alert('Buscagrupo - encontro');
                $("#coin option[value="+ myTypeCoinBalance +"]").attr("selected",true);
            }
            //alert("BuscaGrupoaqui ->  the val " + $(this).val() + " text -> " + $(this).text());
        });
    });

    $('#myTypeCoin').val(myTypeCoinBalance);

}


function BuscaFechas(FechaDesde = 0,FechaHasta = 0){


    if (FechaDesde == 0 || FechaDesde == "" || FechaDesde == null) return;


    let myFechaDesde, myFechaHasta, myFecha;

    myFechaDesde = FechaDesde.toString().substr(8,2)  + '-' + FechaDesde.toString().substr(5,2) + '-' + FechaDesde.toString().substr(0,4);
    myFechaHasta = FechaHasta.toString().substr(8,2)  + '-' + FechaHasta.toString().substr(5,2) + '-' + FechaHasta.toString().substr(0,4);

    myFecha = myFechaDesde.toString()  + ' - ' + myFechaHasta.toString();


    $('#drCustomRanges').data('daterangepicker').setStartDate(myFechaDesde);
    $('#drCustomRanges').data('daterangepicker').setEndDate(myFechaHasta);
    
    // alert(myFechaDesde);

     // $('#myDateControl').daterangepicker({ startDate: myFechaDesde, endDate: myFechaHasta});
     $('#myDateControl').daterangepicker({ startDate: '01-01-2025'});
     $('#myDateControl').daterangepicker({ endDate: '01-31-2025'});
     // $('#myDateControl').val(myFechaDesde + '-' + myFechaHasta);

    // $('#myDateControl').data('daterangepicker').setStartDate(myFechaDesde);
    // $('#myDateControl').data('daterangepicker').setEndDate(myFechaHasta);
       // alert(typeof(myFechaDesde));

    // $('#myDateControl').daterangepicker({
    //     endDate: myFechaHasta,
    //     startDate: myFechaDesde,
    // });
    
    $('#myFechaDesde').val(FechaDesde);
    $('#myFechaHasta').val(FechaHasta);
}

function theRoute(grupo =  null, fechaDesde = null, fechaHasta = null, coin = null){

        let myRoute = "";
        myRoute = "{{ route('balancePagosCobros', ['group' => 'group2','fechaDesde' => 'fechaDesde2', 'fechaHasta' => 'fechaHasta2', 'typeCoin' => 'typeCoin2']) }}";
        myRoute = myRoute.replaceAll('amp;','');
        // console.log("***************** " + myRoute);

        const myGroup           = $('#myGroup').val();
        const myFechaDesde      = $('#myFechaDesde').val();
        const myFechaHasta      = $('#myFechaHasta').val();
        const myTypeCoin        = $('#myTypeCoin').val();

        // console.log('myGroup ->'       + myGroup        + '<-');
        // console.log('myFechaDesde ->'  + myFechaDesde   + '<-');
        // console.log('myFechaHasta ->'  + myFechaHasta   + '<-');
        // console.log('myTypeCoin ->'    + myTypeCoin     + '<-');

        parametros = "";
        if (myGroup != ""){
            myRoute = myRoute.replace('group2',myGroup);
        }else{
            myRoute = myRoute.replace("group=group2&","");
        }

        if (myFechaDesde != ""){
            myRoute = myRoute.replace('fechaDesde2',myFechaDesde);
        }else{

            myRoute = myRoute.replace("fechaDesde=fechaDesde2&","");
            
        }

        if (myFechaHasta != ""){
            myRoute = myRoute.replace('fechaHasta2',myFechaHasta);
        }else{
            myRoute = myRoute.replace("fechaHasta=fechaHasta2&","");
        }

        if (myTypeCoin != ""){
            myRoute = myRoute.replace('typeCoin2',myTypeCoin);
        }else{
            myRoute = myRoute.replace("typeCoin=>typeCoin2","");
        }

        // alert(myRoute);

        // alert(myRoute);

         location.href = myRoute;

}

</script>
@endsection
