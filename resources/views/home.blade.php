@extends('adminlte::page')
@section('title', 'Inicio')

@section('content')
@php
$myTotal = 0;
if (isset($balance->Total)){
    //echo "ajua";
    //var_dump($balance);
    $myTotal = $balance->Total;
}
@endphp


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Información general del sistema MTF') }}</div>

                <div class="card-body">
                   {{-- Updatable --}}
                    @foreach ($wallet as $wallets)
                    <x-adminlte-info-box title="{{ $wallets->name }}" text="{{ $wallets->direction }}" icon="fas fa-lg fa-dollar-sign text-dark"
                    theme="primary"
                    description="{{ $wallets->description }}"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

