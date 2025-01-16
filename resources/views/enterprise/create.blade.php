@extends('adminlte::page')

@section('title', 'MTF| Caja Mayor')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR CAJA MAYOR <i class="fab fa-bitcoin"></i> </h1></a>


@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-5">
        <div class="card-body">
            {!! Form::open(['route' => 'enterprise.store', 'autocomplete' => 'off', 'files' => true]) !!}


            <div class="form-group">
                {!! Form::Label('name', "Nombre:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}


                @error('name')

                <span class="text-danger">{{$message}}</span>

                @enderror

            </div>


            <div class="form-group">
                {!! Form::Label('description', "Observación:") !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true]) !!}

                @error('description')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="form-group">
                <div class="row justify-content-center text-center align-items-center">
                        <select multiple="multiple" id="my-select" name="my-select[]">
                        </select>
                </div>    
            </div>    


            {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}
        </div>
    </div>

</div>
@endsection
@section('js')
<script>
    $( document ).ready(function() {
        InicializaMultiselects();
        cargaWallets();
    });
    

    function cargaWallets(){
        @foreach($wallet as $key => $wallet2)
            // console.log('el grupo con key {!! $key !!} es {!! $wallet2 !!}');
            $('#my-select').multiSelect('addOption', { value: '{!! $key !!}', text: '{!! $wallet2 !!}' });
        @endforeach
    }    

    
    function InicializaMultiselects(){
        $('#my-select').multiSelect({
            selectableHeader: `<div class='custom-header' style='background-color: black; color:white'>
                                    Cajas    
                                    <br><br> 
                                    <div>
                                        <i class='fas fa-circle' style='color: red;'>  </i>
                                    </div>
                                </div>`,
            selectionHeader:  `<div class='custom-header' style='background-color: black; color:white'>
                                     
                                    <br>
                                    <br> 

                                                                        <div>
                                        <i class='fas fa-circle' style='color: green;'></i>
                                    </div>
                                </div>`
        });
    }
</script>
@endsection
