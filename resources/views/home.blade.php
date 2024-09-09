@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $numeroDeOrdenes }}</h3>
                            <p>Total Ordenes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="admin/estadisticas" class="small-box-footer">Ver más <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $entregados }}</h3>
                            <p>Ordenes finalizadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="admin/estadisticas" class="small-box-footer">Ver más <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendientes }}</h3>
                            <p>Ordenes Pendientes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="admin/contactos" class="small-box-footer">Ver más <i
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
@stop

@section('css')
@stop

@section('js')
@stop
