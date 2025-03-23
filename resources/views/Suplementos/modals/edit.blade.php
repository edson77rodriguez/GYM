@foreach($suplementos as $suplemento)
    <div class="modal fade" id="editSuplementoModal{{ $suplemento->id }}" tabindex="-1" aria-labelledby="editSuplementoModalLabel{{ $suplemento->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuplementoModalLabel{{ $suplemento->id }}">Editar Suplemento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('suplementos.update', $suplemento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @include('suplementos.partials.form', ['suplemento' => $suplemento])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
