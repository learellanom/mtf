@extends('adminlte::page')

@section('title', 'MTF| Solicitud')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">SOLICITUD / NOTIFICACION <i class="fab fa-bitcoin"></i> </h1></a>

@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="card col-md-4">
        <div class="card-body">
            
            <input type="hidden" id="user_id"           name="user_id"          value="{{$user->id  ?? ''}}">
            <input type="hidden" id="group_id"          name="group_id"         value="{{$group->GroupID ?? ''}}">
            <input type="hidden" id="transaction_date"  name="transaction_date" value="{{$transaction_requests->transaction_date ?? now()}}">
            
            @php
              // dd($group);
            @endphp

            

            <div class="form-group">
               <label for="amount">Id:</label>

                    <i class="fa-fw fas fa-coins mr-2"></i>
                    <label class="form-control">{{$transaction_request->id ?? ""}}</label>

            </div>

            <div class="form-group">
               <label>Status:</label>

                    <i class="fa-fw fas fa-coins mr-2"></i>
                    <label class="form-control">{{$transaction_request->status ?? ""}}</label>

            </div>
            <div class="form-group">
                <label for="type_transaction_requests_id">Tipo de solicitud:</label>
                <div class="input-group-text">
                    <i class="fa-fw fas fa-dollar-sign mr-2"></i>
                    <label>{{$transaction_request->type_transaction_requests->name ?? ""}}</label>
                </div>
            </div>


            <div class="form-group">
                <label for="amount">Monto:</label>

                    <i class="fa-fw fas fa-coins mr-2"></i>
                    <label class="form-control">{{number_format($transaction_request->amount,2) ?? ""}}</label>                       
             

            </div>

            
            <div class="form-group">
                <label for="description">Observacion:</label>
                
                <label class="form-control" for="description">{{$transaction_request->description ?? ""}}</label>

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
                        <label 
                            class= "form-control font-weight-normal" 
                            id="transaction_date" 
                            name="transaction_date" 
                          >
                            {{$transaction_request->transaction_date ??  "2014-11-16 T 15:25:33"}}</label>
                    <!-- </div> -->
                </div>                    
            
            <div class="form-group">
                <label for="userName">Usuario:</label>
                <label class= "form-control font-weight-normal" id="userName" name="userName">
                    {{$transaction_request->user->name ?? ""}}
                </label>
            </div>
    
            <div class="form-group">
                <label for="groupName">Grupo:</label>
                <label class= "form-control font-weight-normal" id="GroupName" name="GroupName">{{$transaction_request->group->name ?? ""}}</label>
            </div>
          

            <div class="form-group">
                <label for="note">Notas:</label>

                <label class= "form-control" id="note" name="note" value='{{$transaction_request->note ?? ""}}'>
                    {{$transaction_request->transaction_request->note ?? ""}}
                </label>

                @error('note')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div> 


            
            <a class="btn btn-primary btn-block font-weight-bold" href="{{ route('transaction_requests_index') }}" title="Regresar">
                <!-- <i class="fa fa-lg fa-fw fa-pen"></i> -->
                <i class="fa fa-lg fa-arrow-circle-left"></i>
            </a>


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
