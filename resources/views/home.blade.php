@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-12">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $numeroDeOrdenes }}</h3>
                            <p>Total Ordenes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $entregados }}</h3>
                            <p>Ordenes finalizadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="admin/orden/finalizadas" class="small-box-footer">Ver más <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-12">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendientes }}</h3>
                            <p>Ordenes Pendientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="admin/orden/pendiente" class="small-box-footer">Ver más <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $bodega }}</h3>
                            <p>Bodega</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <a href="admin/orden/bodega" class="small-box-footer">Ver más <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Aquí va algo...!!</h3>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>

            </div>
    </section>

    <div class="row">
        <!-- Log on to codeastro.com for more projects! -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>

                    <p>System Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-secret"></i>
                </div>
                <a href="/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ \App\Models\Category::count() }}<sup style="font-size: 20px"></sup></h3>

                    <p>Category</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ \App\Models\Product::count() }}</h3>
                    <p>Product</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <a href="{{ route('products.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ \App\Models\Customer::count() }}</h3>

                    <p>Customer</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- Log on to codeastro.com for more projects! -->


    <div class="row">

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ \App\Models\Supplier::count() }}<sup style="font-size: 20px"></sup></h3>

                    <p>Supplier</p>
                </div>
                <div class="icon">
                    <i class="fa fa-signal"></i>
                </div>
                <a href="{{ route('suppliers.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
                <div class="inner">
                    <h3>{{ \App\Models\Product_Masuk::count() }}</h3>

                    <p>Total Purchase</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cart-plus"></i>
                </div>
                <a href="{{ route('productsIn.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ \App\Models\Product_Keluar::count() }}</h3>

                    <p>Total Outgoing</p>
                </div>
                <div class="icon">
                    <i class="fa fa-minus"></i>
                </div>
                <a href="{{ route('productsOut.index') }}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div id="container" class=" col-xs-6"></div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
