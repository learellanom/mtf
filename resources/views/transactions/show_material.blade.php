
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="card-title text-uppercase font-weight-bold">Transacción numero #{{ $transactions->id }}
                        @php
                            if($transactions->status == 'Activo') {
                                $myBadge = "badge badge-success";
                            }else{
                                $myBadge = "badge badge-danger";
                            }
                        @endphp
                        <span class="{{$myBadge}}" id="myBadge">{{ $transactions->status }}</span>

                        {{-- @if($transactions->status == 'Activo') <span class="badge badge-success" id="myBadge">{{ $transactions->status }}</span> @else <span class="badge badge-danger">{{ $transactions->status }}</span> @endif </h3> --}}
                    </div>  
                    
                    @php

                    @endphp
                    <div class="col-lg-8 justify-content-end align-items-right text-right">
                        
                        @can('transactions.update_status')            
                            @php
                                
                                $indMuestra = 1;
                                if ($myAdministrator == false){
                                    if ($transactions->user_id != auth()->id()){
                                        $indMuestra = 0;
                                    }
                                }
                                 
                                if ($transactions->status == 'Activo') {
                                    $myColor = "btn btn-xl text-success mx-1 shadow text-center";
                                    $myIcon = "fa fa-lg fa-fw fas fa-check";
                                    $myText = "Anular";                        
                                }else{
                                    $myColor = "btn btn-xl text-danger mx-1 shadow text-center";
                                    $myIcon = "fa fa-lg fa-fw fas fa-times ";
                                    $myText = "Activar";
                                }
                            @endphp 
                            @if($indMuestra == 1)
                                <button class="{{ $myColor }}" 
                                    id="myBtnAnular"
                                    onclick="apiUpdateStatus();"
                                    title="Activo">
                                    <i id="myIcon" class="{{$myIcon}}"></i><p id="myText" style="display: block;">{{ $myText }}</p>
                                </button>
                                
                                <button class="btn btn-xl text-success mx-1 shadow text-center " 
                                    title="Activo"
                                    onclick="editTransaction();"
                                    >
                                    <i class="fas fa-lg fa-fw fa-coins"></i><p style="display: block;">Editar</p>
                                </button>
                                
                            @else
                                <button class="{{ $myColor }}" 
                                    id="myBtnAnular"
                                    onclick=""
                                    title="Activo"
                                    disabled
                                    style="color: gray !important;"
                                    >
                                    <i id="myIcon" class="{{$myIcon}}"></i><p id="myText" style="display: block;">{{ $myText }}</p>
                                </button>
                                <button class="btn btn-xl text-success mx-1 shadow text-center " 
                                    title="Activo"
                                    onclick=""
                                    disabled
                                    style="color: gray !important;"
                                    >
                                    <i class="fas fa-lg fa-fw fa-coins"></i><p style="display: block;">Editarr</p>
                                </button>                            
                            @endif
                        @endcan
                    </div>
                </div>
            </div>

            <div class="card-body">

                
                    
                <div class="form-row">
                    <div class="col-12 col-sm-4 mt-4 mb-4">
                        <div class="info-box bg-light" style="min-height: 100%;">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Transacción <i class="fas fa-trademark"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->type_transaction->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 mt-4 mb-4">
                        <div class="info-box bg-light" style="min-height: 100%;">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Caja <i class="fas fa-box"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ ($transactions->wallet->name) ?  $transactions->wallet->name :  ""}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4 mt-4 mb-4">
                        <div class="info-box bg-light" style="min-height: 100%;">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                @if($transactions->group_id)
                                    @if($transactions->group->type == 2)   
                                        Caja Destino  
                                    @else 
                                        Grupo 
                                    @endif  
                                @else
                                    
                                @endif
                                    <i class="fas fa-hand-holding-usd"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">

                                @if($transactions->group_id)
                                        @if($transactions->group->type == 2)   
                                            {{ $transactions->wallet->name}} 

                                        @else
                                        {{ $transactions->group->name }} 
                                        @endif
                                    @endif
                                
                                </span>
                            </div>
                        </div>
                    </div>               

                </div>

                <hr>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tipo de material <i class="fas fa-funnel-dollar"></i></span>
                                <span class="info-box-number text-center text-muted mb-0">{{ $transactions->type_material->name }}</span>
                            </div>
                        </div>
                    </div>                    
                </div>


                <!-- tipo de adquisicion -->
                @php 

                    $myClass	            = new app\Http\Controllers\TransactionController;
                    $myDesTypeAdquisicion   = $myClass->getDesTyperAdquisicion($transactions->material_type_adquisicion);

                @endphp 

                <div class="form-row">
                    <div class="form-group col-md-9">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tipo de adquisicion <i class="fas fa-funnel-dollar"></i></span>
                                <span class="info-box-number text-center text-muted mb-0">{{ $myDesTypeAdquisicion}}</span>
                            </div>
                        </div>
                    </div>                    
                </div>


                <div class="form-row">


                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                    Cantidad<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_kilos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Precio/U:<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_price_kilos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>



                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Monto Total Material<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_total_kilos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                <hr>



                <div class="form-row">

                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                    Cantidad<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_gramos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Precio/U:<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_price_gramos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>




                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Monto Total Material<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_total_gramos,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                <hr>



                <div class="form-row">


                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                    Cantidad<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_cantidad,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Precio/U:<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_price_cantidad,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>




                    <div class="form-group col-md-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">
                                Monto Total Material<i class="fas fa-hryvnia"></i>
                                </span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                    {{ number_format($transactions->material_amount_total_cantidad,2,",",".") ?? '0.00' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                <hr>                

                <div class="form-row">
                                            
                    <div class="col-xl-4 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha <i class="fas fa-text-width"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->transaction_date ?? 'SIN DESCRIPCIÓN' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-row">
                                            
                    <div class="col-12 col-sm-12">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Descripción <i class="fas fa-text-width"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->description ?? 'SIN DESCRIPCIÓN' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
