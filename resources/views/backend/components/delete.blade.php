

<form id="{{$form_id ?? 'delete_form'}}_{{$data ?? ''}}" method="POST" action="{{ $route ?? '/' }}" style="display: inline-block;vertical-align: middle;">
    @csrf
    {{ method_field('DELETE') }}
	<button title="Delete record" type="button" onclick="deleteConfirm('{{$form_id ?? null}}','{{$data ?? ''}}')" class="btn btn-danger btn-tone d-flex">
        <i class="fas fa-trash "></i>
        <span class="m-{{$alignShortRev}}-5">Delete</span>
    </button>
</form>