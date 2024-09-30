    @extends('adminlte::page')


    @section('title', 'Perfil')

    @section('content')
        <div class="container">
            <h1>Editar Perfil</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Celular</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $user->phone) }}" required>
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña (dejar en blanco si no deseas cambiarla)</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>


                <div class="form-group">
                    <label for="signature">Subir Firma</label>
                    <input type="file" name="signature" class="form-control @error('signature') is-invalid @enderror">
                    @error('signature')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($user->signature)
                        {{-- firma actual --}}
                        <br>
                        <label for="firma">Firma Actual</label> <br>
                        <img src="{{ asset('storage/' . $user->signature) }}" alt="Firma actual" width="200"
                            class="mt-2">
                    @endif
                </div>
                <br>
                {{-- boton hacia la derecha --}}
                <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
            </form>
        </div>
    @endsection
