<form method="post" action="{{$url}}" class="d-inline">
    @csrf
    @method('delete')
    <input name="_method" value="delete" hidden>
    <button type="button" data-name="{{$name}}"  class="btn button-db">
        <i class="fa fa-trash-alt"></i>
    </button>
</form>
