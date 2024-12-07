@extends('adminlte::page')

@section('title', 'MTF| Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">CREAR NOTIFICACION <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            {!! Form::open(['class' => "entre", 'route' => 'transaction_requests.store', 'autocomplete' => 'off', 'files' => true, 'id' => 'entre']) !!}

            
            <input type="hidden" id="user_id"           name="user_id"          value="{{$user->id  ?? ''}}">
            <input type="hidden" id="group_id"          name="group_id"         value="{{$group->GroupID ?? ''}}">
            <input type="hidden" id="transaction_date"  name="transaction_date" value="{{$transaction_date ?? now()}}">
            
            @php
              // dd($group);
            @endphp
            <div class="form-group">
                <label for="type_transaction_requests_id">Tipo de Notificacion:</label>
                <div class="input-group-text">
                    <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                    <select class="form-control" name="type_transaction_requests_id" id="type_transaction_requests_id">
                        @foreach($type_transaction_request as $key => $item)
                            <option value="{{$key}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="amount">Monto:</label>
                <!-- <div class="input-group-text"> -->
                    <i class="fa-fw fas fa-coins mr-2"></i>
                    <input class="form-control claseMonto" type="text" id="amount" name="amount" required>
                <!-- </div> -->
            </div>

            
            <div class="form-group">
                <label for="description">Observacion:</label>
                <input class="form-control" type="text" id="description" name="description">             


                @error('description')
                    <small class="text-danger">{{$message}}</small> 
                @enderror
            </div>  
            <hr class="mt-5 mb-5" style="border: 1px solid #ced4da">
            
                <div class="form-group">
                    
                    <label for="transaction_date">Fecha:</label>
                    <!-- <div class="input-group-text"> -->
                        <i class="fa-fw fas fas fa-calendar-week mr-2"></i>
                        
                        {{--<input type="datetime-local" id="transaction_date" value="2014-11-16T15:25:33">--}}
                        <label class= "form-control font-weight-normal" id="transaction_date" name="transaction_date" value="'{{$transaction_date ? $transaction_date->format('d-m-Y') :  '2014-11-16 T 15:25:33'}}'">{{$transaction_date ? $transaction_date->format('d-m-Y') :  "2014-11-16 T 15:25:33"}}</label>
                    <!-- </div> -->
                </div>                    
            
            <div class="form-group">
                <label for="userName">Usuario:</label>
                <label class= "form-control font-weight-normal" id="userName" name="userName">{{$user->name ? $user->id . " " . $user->name :  ""}}</label>
            </div>
    
            <div class="form-group">
                <label for="groupName">Grupo:</label>
                <label class= "form-control font-weight-normal" id="GroupName" name="GroupName" value='{{$group->GroupName ?? ""}}'>{{$group->GroupName ?? ""}}</label>
            </div>
          

            <div class="form-group">
                <label for="note">Notas:</label>

                <label class= "form-control" id="note" name="note" value='{{$transaction_request->note ?? ""}}'></label>

                @error('note')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div> 

            {!! Form::Submit('GUARDAR', ['class' => 'btn btn-primary btn-block font-weight-bold']) !!}

            {!! Form::close() !!}
        </div>
    </div>

</div>
@endsection

@section('js')

<script>

    $('.claseMonto').inputmask({
        alias: 'decimal',
        autoUnmask:true,
        removeMaskOnSubmit:true,
        rightAlign: true,
        groupSeparator:".",
        undoOnEscape:true,
        insertMode:false,
        clearIncomplete:true,
        digits: 2,
        autoClear: true,
        insertMode:true, });


    $(document).ready(function() {

        $('#type_transaction_request_id').on('change', function() {
            alert($(this).val() );
        });

        $('#entre').on('submit', function() {

            // alert($('#type_transaction_request_id').val());
            

            // if (trim($('#amount').val()) ==  ""){
                
            //     Swal.fire({
            //             position: 'left',
            //             type: 'error',
            //             title: `Error: Monto es requerido`,
            //             showConfirmButton: true
            //         });               
                
            //     return false;
            // }
            // alert('pasa');

            // return false;
            return true;

        });

    });

</script>
@endsection
