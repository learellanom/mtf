<div class="card-body">

    <div class="row">
        <div class="col-12 col-md-12 col-xl-8 order-2 order-md-1">
            <div class="row col-12">
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Transacción <i class="fas fa-trademark"></i></span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->type_transaction->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Caja <i class="fas fa-box"></i></span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ ($transactions->wallet->name) ?  $transactions->wallet->name :  ""}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
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
            
            <hr>  
            <div class="row mt-4 mb-4">
                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Tipo de material <i class="fas fa-funnel-dollar"></i></span>
                            <span class="info-box-number text-center text-muted mb-0">{{ $transactions->type_material->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-3">

                </div>

                <div class="col-12 col-sm-3">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Cantidad<i class="fas fa-hryvnia"></i>
                            </span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                {{ number_format($transactions->material_amount,2,",",".") ?? '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- tipo de adquisicion -->
            @php 

                $myClass	            = new app\Http\Controllers\TransactionController;
                $myDesTypeAdquisicion   = $myClass->getDesTyperAdquisicion($transactions->material_type_adquisicion);

                $myStyle1 = "";
                $myStyle2 = "";
                $myStyle3 = "";
                switch($transactions->material_type_adquisicion){
                    case 1:
                        $myStyle1 = "border: 1px solid navy;";
                        break;
                    case 2:
                        $myStyle2 = "border: 1px solid navy;";
                        $myStyle = "";
                        break;
                    case 3:
                        $myStyle3 = "border: 1px solid navy;";
                        break;
                    default:
                        break;
                }

            @endphp 

            <div class="form-row">
                <div class="form-group col-12">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Tipo de adquisicion <i class="fas fa-funnel-dollar"></i></span>
                            <span class="info-box-number text-center text-muted mb-0">{{ $myDesTypeAdquisicion}}</span>
                        </div>
                    </div>
                </div>                    
            </div>

            <div class="form-row pt-4" >

                <div class="form-group col-md-3" style="{{ $myStyle1 }}">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Cantidad Kilos<i class="fas fa-hryvnia"></i>
                            </span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                {{ number_format($transactions->material_amount_kilos,2,",",".") ?? '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row pt-4" >
                <div class="form-group col-md-3" style="{{ $myStyle2 }}">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Gramos<i class="fas fa-hryvnia"></i>
                            </span>
                            <span class="info-box-number text-center text-muted mb-0 text-uppercase">
                                {{ number_format($transactions->material_amount_gramos,2,",",".") ?? '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row pt-4" >
                <div class="form-group col-md-3" style="{{ $myStyle3 }}">
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
            </div>

            <hr>                        
            <div class="row">
                <div class="col-12">

                <div class="row">


                    @php 
                        $myDate = date_create($transactions->transaction_date);
                    @endphp 
                    
                    <div class="col-12 col-sm-4 col-xl-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha Transaccion <i class="fas fa-calendar"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-danger">{{ date_format($myDate,"d/m/Y H:i:s") }}</span>
                            </div>
                        </div>
                    </div>         


                    <div class="col-12 col-sm-4 col-xl-3">
                    </div>

                    <div class="col-12 col-sm-4 col-xl-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Agente <i class="fas fa-user"></i></span>
                                <span class="info-box-number text-center text-muted mb-0 text-uppercase">{{ $transactions->user->name }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <hr>
            <div class="row col-12">
                
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
</div>