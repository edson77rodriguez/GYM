@extends('layouts.app')

@section('template_title')
    Gestión de Proveedores
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .card-proveedor {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-proveedor:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .avatar-proveedor {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
    }
    .badge-rol {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    .action-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 3px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">
                    <i class="fas fa-truck me-2"></i> Gestión de Proveedores
                </h2>
                <button class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                    {{ __('Regresar a Home') }}
                </button>
                <button class="btn btn-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#createProveedorModal">
                    <i class="fas fa-plus me-2"></i> Nuevo Proveedor
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless mb-0" id="proveedoresTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 ps-4" style="width: 50px;"></th>
                                    <th class="py-3">Proveedor</th>
                                    <th class="py-3">Contacto</th>
                                    <th class="py-3">Estado</th>
                                    <th class="py-3 text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $proveedor)
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <div class="avatar-proveedor bg-primary text-white d-flex align-items-center justify-content-center">
                                            {{ substr($proveedor->persona->nom, 0, 1) }}{{ substr($proveedor->persona->ap, 0, 1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1">{{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}</h6>
                                        <small class="text-muted">{{ $proveedor->persona->correo }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-phone-alt me-2 text-muted"></i>
                                            <span>{{ $proveedor->persona->telefono }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Activo</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary action-btn view-btn" 
                                                data-id="{{ $proveedor->id_proveedor }}"
                                                data-nombre="{{ $proveedor->persona->nom }} {{ $proveedor->persona->ap }}"
                                                data-telefono="{{ $proveedor->persona->telefono }}"
                                                data-correo="{{ $proveedor->persona->correo }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning action-btn edit-btn">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger action-btn delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Proveedor -->
<div class="modal fade" id="createProveedorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createProveedorForm" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido Paterno *</label>
                            <input type="text" name="ap" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="am" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Correo Electrónico *</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Contraseña *</label>
                            <div class="input-group">
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Mínimo 8 caracteres</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save me-2"></i> Guardar Proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver Proveedor -->
<div class="modal fade" id="viewProveedorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewProveedorModalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-proveedor bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;" id="proveedorAvatar"></div>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-phone-alt me-2 text-muted"></i> Teléfono</span>
                        <strong id="proveedorTelefono"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-envelope me-2 text-muted"></i> Correo</span>
                        <strong id="proveedorCorreo"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user-tag me-2 text-muted"></i> Rol</span>
                        <span class="badge bg-primary">Proveedor</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar Proveedor -->
<div class="modal fade" id="editProveedorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Editar Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProveedorForm" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="proveedor_id" id="edit_proveedor_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="edit_nom" id="edit_nom" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido Paterno *</label>
                            <input type="text" name="edit_ap" id="edit_ap" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="edit_am" id="edit_am" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" name="edit_telefono" id="edit_telefono" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Correo Electrónico *</label>
                            <input type="email" name="edit_correo" id="edit_correo" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                            <div class="input-group">
                                <input type="password" name="edit_contrasena" id="edit_contrasena" class="form-control">
                                <button class="btn btn-outline-secondary toggle-edit-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Mínimo 8 caracteres</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-save me-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas eliminar este proveedor? Esta acción no se puede deshacer.</p>
                <p class="mb-0 fw-bold" id="proveedorToDelete"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función para editar proveedor
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const proveedorId = this.closest('tr').querySelector('.view-btn').getAttribute('data-id');
        
        fetch(`/GPM/${proveedorId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_proveedor_id').value = data.id_proveedor;
                document.getElementById('edit_nom').value = data.persona.nom;
                document.getElementById('edit_ap').value = data.persona.ap;
                document.getElementById('edit_am').value = data.persona.am || '';
                document.getElementById('edit_telefono').value = data.persona.telefono;
                document.getElementById('edit_correo').value = data.persona.correo;
                
                const modal = new bootstrap.Modal(document.getElementById('editProveedorModal'));
                modal.show();
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del proveedor'
                });
            });
    });
});

// Función para eliminar proveedor
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const proveedorId = this.closest('tr').querySelector('.view-btn').getAttribute('data-id');
        const proveedorNombre = this.closest('tr').querySelector('.view-btn').getAttribute('data-nombre');
        
        document.getElementById('proveedorToDelete').textContent = proveedorNombre;
        document.getElementById('deleteForm').action = `/GPM/${proveedorId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    });
});

// Toggle password visibility para editar
document.querySelectorAll('.toggle-edit-password').forEach(button => {
    button.addEventListener('click', function() {
        const passwordInput = document.getElementById('edit_contrasena');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});

// Formulario editar proveedor
const editForm = document.getElementById('editProveedorForm');
if (editForm) {
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const proveedorId = document.getElementById('edit_proveedor_id').value;
        
        fetch(`/GPM/${proveedorId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editProveedorModal'));
                    modal.hide();
                    location.reload();
                });
            }
        })
        .catch(error => {
            if (error.response) {
                error.response.json().then(err => {
                    let errorMessage = '';
                    for (const key in err.errors) {
                        errorMessage += `${err.errors[key][0]}\n`;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de validación',
                        text: errorMessage
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar el proveedor'
                });
            }
        });
    });
}

// Formulario eliminar proveedor
const deleteForm = document.getElementById('deleteForm');
if (deleteForm) {
    deleteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'DELETE'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
                    modal.hide();
                    location.reload();
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al eliminar el proveedor'
            });
        });
    });
}
// Asegúrate que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // 1. Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = document.getElementById('contrasena');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // 2. Modal para ver proveedor
    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function() {
            const nombre = this.getAttribute('data-nombre');
            const iniciales = nombre.split(' ').map(n => n[0]).join('');
            
            document.getElementById('viewProveedorModalTitle').textContent = nombre;
            document.getElementById('proveedorAvatar').textContent = iniciales;
            document.getElementById('proveedorTelefono').textContent = this.getAttribute('data-telefono');
            document.getElementById('proveedorCorreo').textContent = this.getAttribute('data-correo');
            
            // Mostrar modal con vanilla JS
            const modal = new bootstrap.Modal(document.getElementById('viewProveedorModal'));
            modal.show();
        });
    });

    // 3. Formulario crear proveedor
    const createForm = document.getElementById('createProveedorForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('createProveedorModal'));
                        modal.hide();
                        location.reload();
                    });
                }
            })
            .catch(error => {
                if (error.response) {
                    error.response.json().then(err => {
                        let errorMessage = '';
                        for (const key in err.errors) {
                            errorMessage += `${err.errors[key][0]}\n`;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: errorMessage
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al crear el proveedor'
                    });
                }
            });
        });
    }
});
</script>
@endpush