<select name="id_bph" id="id_bph" class="form-select" required>
    @foreach ($bphList as $divisi)
        <option value="{{ $divisi->id_bph }}">{{ $divisi->nama_divisi_bph }}</option>
    @endforeach
</select>
