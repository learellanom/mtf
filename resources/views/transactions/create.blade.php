@extends('adminlte::page')

@section('title', 'Movimientos')

@section('content_header')

    <h1 class="text-center text-dark font-weight-bold">NUEVO MOVIMIENTO <i class="fas fa-users"></i> </h1></a>


@stop

@section('content')

<div class="d-flex justify-content-center">
 <div class="card col-md-6">
  <div class="card-body">

    <div class="form-row">
    <div class="form-group col-md-6">
        <x-adminlte-select name="selVehicle" label="Tipo de divisa" label-class="text-lightblue"
        igroup-size="md" >
        <x-slot name="prependSlot">
            <div class="input-group-text bg-gradient-info">
                <i class="fas fa-money-bill-alt"></i>
            </div>
        </x-slot>
        
        <option>Dolar</option>
        <option>Euro</option>
        <option>VEF</option>
        <option>RMB</option>
    </x-adminlte-select>
    </div>
    <div class="form-group col-md-6">
        <x-adminlte-input name="iUser" label="Tasa" placeholder="" label-class="text-lightblue">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
</div>


<div class="form-group col-md-14">
    <x-adminlte-input name="iUser" label="Equivalancia al dolar" label-class="text-lightblue">
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
</div>

    <div class="form-row">
    <div class="form-group col-md-6">
        <x-adminlte-input name="iUser" label="Porcentaje" label-class="text-lightblue">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-percentage"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="form-group col-md-6">
        <x-adminlte-input name="iUser" label="Monto de comision" placeholder="" label-class="text-lightblue" type='number'>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
  </div>

  



  <div class="form-group">
    <x-adminlte-input name="iUser" label="Monto" placeholder="" label-class="text-lightblue" type='number'>
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </x-slot>
    </x-adminlte-input>
  </div>
  <div class="form-group">
    <x-adminlte-textarea name="iUser" label="Descripcion" placeholder="" label-class="text-lightblue" type='textarea'>
        <x-slot name="prependSlot">
            <div class="input-group-text">
                <i class="far fa-sticky-note text-lightblue"></i>
            </div>
        </x-slot>
    </x-adminlte-textarea>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
        <x-adminlte-input name="iUser" label="Suift" placeholder="" label-class="text-lightblue" type='number'>
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-sort-numeric-up-alt"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
    <div class="form-group col-md-4">
        <x-adminlte-select name="selVehicle" label="Clientes" label-class="text-lightblue"
        igroup-size="md" >
        <x-slot name="prependSlot">
            <div class="input-group-text bg-gradient-info">
                <i class="fas fa-users"></i>
            </div>
        </x-slot>
        
        <option>Antonio Jose</option>
        <option>Pedro Jesus</option>
        <option>Luis Jose</option>
    </x-adminlte-select>
    </div>
    <div class="form-group col-md-4">
        <x-adminlte-input name="iUser" label="Saldo" placeholder="" label-class="text-lightblue" type="number">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-dollar-sign text-lightblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>
    </div>
  </div>
 

            <button type="submit" class="btn btn-primary text-uppercase font-weight-bold btn-block">Guardar</button>
        </form>
       </div>
      </div>
    </div>

















@endsection