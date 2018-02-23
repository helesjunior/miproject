<a href="{{route($action['route'],[$row->getKey()])}}" title="Excluir" class="btn btn-default btn-sm"
   onclick="event.preventDefault();if(confirm('Deseja excluir este item?')){document.getElementById('form-delete-{{$row->getKey()}}').submit();}">
    <i class="fa fa-trash"></i>
</a>

<form id="form-delete-{{$row->getKey()}}"
      action="{{route($action['route'],[$row->getKey()])}}"
      method="POST" style="display: none;">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
</form>