@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.users') }}
@endsection


@section('main-content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Usuário</h3>
                <div class="box-tools pull-right">
                    <a href="/admin/users" class="btn btn-box-tool"  title="Voltar">
                        <i class="fa fa-times"></i>
                    </a>
                </div>

            </div>
            <div class="box-body">
                {!! form($form->add('edit','submit',[
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ],
                    'label' => Icon::create('floppy-disk').'&nbsp;&nbsp;Editar'
                ])) !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

    <!-- /.box -->
    {{--@include('adminlte::newuserform')--}}
    {{--@include('adminlte::mod.admin.deletemodal')--}}
@endsection