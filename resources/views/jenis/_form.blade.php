<div class="mb-3">
    <label>Nama Jenis</label><br>
    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $jenis->nama ?? '') }}">
    @error('nama')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<button class="btn btn-success mt-3" type="submit">Simpan</button>
<a href="{{ route('jenis.index') }}" class="btn btn-secondary mt-3">Kembali</a>