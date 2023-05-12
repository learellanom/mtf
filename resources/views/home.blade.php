@extends('adminlte::page')
@section('title', 'Inicio')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Información general del sistema MTF') }}</div>

                <div class="card-body">
                   {{-- Updatable --}}
                    @foreach ($wallet as $wallets)
                    <x-adminlte-info-box title="{{ $wallets->name }}" text="{{ $wallets->direction }}" icon="fas fa-lg fa-box text-dark"
                    theme="secondary"
                    description="{{ $wallets->description }}"/>

                    @endforeach

                </div>
                <div class="card-footer">
                    {{$wallet->links()}}
                </div>






                </div>

            </div>

         </div>


@endsection

