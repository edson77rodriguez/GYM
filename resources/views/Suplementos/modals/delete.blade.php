@foreach($suplementos as $suplemento)
    <div class="modal fade" id="deleteSuplementoModal{{ $suplemento->id }}" tabindex="-1" aria-labelledby="deleteSuplementoModalLabel{{ $suplemento->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSuplementoModalLabel{{ $suplemento->id }}">Eliminar Suplemento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar el suplemento <strong>{{ $suplemento->nom_suplemento }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('suplementos.destroy', $suplemento->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach