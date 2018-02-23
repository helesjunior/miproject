@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.users') }}
@endsection


@section('main-content')

    <!-- Default box -->
    <div class="box box-solid box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Listagem de Usuários</h3>
        </div>
        <div class="box-body">
            <div class="box-tools">
                {!! Button::primary('Novo usuário')->asLinkTo(route('admin.users.create')) !!}
            </div>
            <br/>
                <div class="col-sm-12">
                    @include('vendor.adminlte.table.table')
                </div>
        </div>


        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    {{--@include('adminlte::newuserform')--}}
    {{--@include('adminlte::mod.admin.deletemodal')--}}
@endsection