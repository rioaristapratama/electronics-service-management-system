<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h3 class="mb-4">{{ $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna' }}</h3>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor telepon</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select" required>
                        <option value="">Pilih role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                @selected(old('role_id', $user->role_id) == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password {{ $isEdit ? '(kosongkan jika tidak diubah)' : '' }}
                    </label>
                    <input type="password" name="password" class="form-control"
                           {{ $isEdit ? '' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           {{ $isEdit ? '' : 'required' }}>
                </div>

                <div class="mb-4">
                    <label class="form-label">Status akun</label>
                    <select name="is_active" class="form-select" required>
                        <option value="1" @selected(old('is_active', $user->exists ? (int) $user->is_active : 1) == 1)>
                            Aktif
                        </option>
                        <option value="0" @selected(old('is_active', $user->exists ? (int) $user->is_active : 1) == 0)>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
