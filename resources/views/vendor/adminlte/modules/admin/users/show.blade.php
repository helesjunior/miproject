@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.users') }}
@endsection


@section('main-content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Visualizar Usuário</h3>
                <div class="box-tools pull-right">
                    <a href="/admin/users" class="btn btn-box-tool"  title="Voltar">
                        <i class="fa fa-times"></i>
                    </a>
                </div>

            </div>
            <div class="box-body">
                @php
                    $linkEdit = route('admin.users.edit',['user' => $user->id]);
                    $linkDelete = route('admin.users.destroy',['user' => $user->id]);
                @endphp
                {!! Button::primary(Icon::pencil().' Editar')->asLinkTo($linkEdit)->small()->addAttributes(['class' => 'hidden-print']) !!}
                {!!
                Button::danger(Icon::remove().' Excluir')->asLinkTo($linkDelete)
                ->addAttributes([
                    'onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();",
                    'class' => 'hidden-print'
                ])->small()
                !!}
                @php
                    $formDelete = FormBuilder::plain([
                        'id' => 'form-delete',
                        'url' => $linkDelete,
                        'method' => 'DELETE',
                        'style' => 'display:none'
                        ])
                @endphp
                {!! form($formDelete) !!}
                <br><br>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{{$user->id}}</td>
                    </tr>
                    <tr>
                        <th scope="row">CPF / CNPJ</th>
                        <td>{{$user->cpfcnpj}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    </tbody>
                </table>
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