<div class="mb-3">
    <label for="nom_suplemento" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nom_suplemento" name="nom_suplemento" 
        value="{{ old('nom_suplemento', $suplemento->nom_suplemento ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="id_categoria" class="form-label">Categoría</label>
    <select class="form-control" id="id_categoria" name="id_categoria" required>
        <option>Selecciona</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" 
                {{ (isset($suplemento) && $suplemento->id_categoria == $categoria->id) ? 'selected' : '' }}>
                {{ $categoria->nom_cat }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="id_marca" class="form-label">Marca</label>
    <select class="form-control" id="id_marca" name="id_marca" required>
    <option>SSelecciona</option>
        @foreach($marcas as $marca)
            <option value="{{ $marca->id }}" 
                {{ (isset($suplemento) && $suplemento->id_marca == $marca->id) ? 'selected' : '' }}>
                {{ $marca->nom_marca }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="desc_suplemento" class="form-label">Descripción</label>
    <textarea class="form-control" id="desc_suplemento" name="desc_suplemento" rows="3">{{ old('desc_suplemento', $suplemento->desc_suplemento ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label for="precio" class="form-label">Precio</label>
    <input type="number" class="form-control" id="precio" name="precio" step="0.01" 
        value="{{ old('precio', $suplemento->precio ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" class="form-control" id="stock" name="stock" 
        value="{{ old('stock', $suplemento->stock ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="imagen_suplemento" class="form-label">Imagen</label>
    <input type="file" class="form-control" id="imagen_suplemento" name="imagen_suplemento" accept="image/*">
    @if(isset($suplemento) && $suplemento->imagen_suplemento)
        <img src="{{ asset('storage/' . $suplemento->imagen_suplemento) }}" class="img-thumbnail mt-2" width="100">
    @endif
</div>