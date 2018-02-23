<form action="{{url()->current()}}" method="GET" class="form-inline">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-search"></span>
            </div>
            <input type="text" class="form-control" name="search" placeholder="Pesquisar"
                   value="{{\Request::get('search')}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Pesquisar</button>
</form>
<div align="right">
    <span>Mostrar </span>
    <select name="rows-per-page" data-url="#">
        <option value="10" >10</option>
        <option value="10" >20</option>
        <option value="10" >50</option>
        <option value="10" >100</option>
    </select>
    <span>por página</span>
</div>
@if(count($table->rows()))
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered" id="table-search">
            <thead class="bg-info">
            <tr>
                @foreach($table->columns() as $column)
                    <th data-name="{{$column['name']}}">
                        {{$column['label']}}
                        @if(isset($column['_order']))
                            @php
                                $icons = [
                                    1 => 'fa fa-sort',
                                     'asc' => 'fa fa-sort-asc',
                                     'desc' => 'fa fa-sort-desc',
                                ];
                            @endphp
                            <a href="javascript:void(0)">
                                <span class="glyphicon {{$icons[$column['_order']]}}"></span>
                            </a>
                        @endif
                    </th>
                @endforeach
                @if(count($table->actions()))
                    <th>Ações</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($table->rows() as $row)
                <tr>
                    @foreach($table->columns() as $column)
                        <td>{{ $row->{$column['name']} }}</td>
                    @endforeach
                    @if(count($table->actions()))
                        <td>
                            <div class="btn-group">
                                @foreach($table->actions() as $action)
                                    @include($action['template'],[
                                            'row' => $row,
                                            'action' => $action,
                                        ])
                                @endforeach
                                @if(count($table->actionsMore()))
                                    <button type="button" title="Mais" class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown"><i class="fa fa-gears"></i>
                                        <span class="fa fa-caret-down"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                    @foreach($table->actionsMore() as $actionMore)
                                        @include($actionMore['template'],[
                                            'row' => $row,
                                            'action' => $actionMore,
                                        ])
                                    @endforeach
                                    </ul>
                                @endif
                            </div>
                        </td>
                    @endif

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-6 col-md-4">
            Página <b>{!! $table->rows()->currentPage() !!}</b> de <b>{!! $table->rows()->lastPage() !!}</b>. Total de <b>{!! $table->rows()->total() !!}</b> registros.
        </div>
        <div class="col-12 col-md-8" align="right">
            {!! $table->rows()->appends(['search' => \Request::get('search'),'field_order' => \Request::get('field_order'),'order' =>\Request::get('order')])->links() !!}
        </div>
    </div>
@else
    <table class="table">
        <tr>
            <td>Nenhum registrado encontrado</td>
        </tr>
    </table>
@endif

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#table-search>thead>tr>th[data-name]>a')
                .click(function(){
                    var anchor = $(this);
                    var field = anchor.closest('th').attr('data-name');
                    var order =
                        anchor.find('span').hasClass('fa-sort-desc') || anchor.find('span').hasClass('fa fa-sort')
                            ? 'asc':'desc';
                    var url = "{{url()->current()}}?";
                    @if(\Request::get('page'))
                        url += "page={{\Request::get('page')}}&";
                    @endif
                            @if(\Request::get('search'))
                        url += "search={{\Request::get('search')}}&";
                    @endif
                        url+='field_order='+field+'&order='+order;
                    window.location = url;
                })
        });
    </script>
@endpush