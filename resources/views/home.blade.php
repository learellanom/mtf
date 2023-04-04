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
                    <x-adminlte-info-box title="MASTER" text="$50.000.00" icon="fas fa-lg fa-dollar-sign text-dark"
                    theme="success"
                    description="Esta caja posee ingresos solo en trasnferencias"/>


                    <x-adminlte-info-box title="EFECTIVO" text="$100.000.00" icon="fas fa-lg fa-wallet text-dark"
                    theme="info"
                    description="Esta caja posee ingresos solo en efectivo"/>
                </div>
            </div>
        </div>
    </div>
</div>





@endsection

