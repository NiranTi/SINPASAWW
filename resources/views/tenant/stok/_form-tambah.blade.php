{{-- resources/views/tenant/stok/_form-tambah.blade.php --}}

{{-- Nama Barang --}}
<div class="form-group">
    <label class="form-label ml-0 md:ml-4">NAMA BARANG</label>
    <input type="text" name="nama"
           class="form-input @error('nama') ring-2 ring-red-300 @enderror"
           value="{{ old('nama') }}" placeholder="Nama barang..." required>
    @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
</div>

{{-- Harga Jual --}}
<div class="form-group">
    <label class="form-label ml-0 md:ml-4">HARGA JUAL</label>
    <div class="input-prefix-wrap">
        <span class="input-prefix"> Rp </span>
        <input type="number" name="harga_jual"
               class="form-input has-prefix"
               value="{{ old('harga_jual') }}" placeholder="0" min="0" required>
    </div>
</div>

{{-- Stok + Unit (2 kolom) --}}
<div class="grid grid-cols-2 gap-3 mb-4">
    <div class="form-group mb-0"> 
        <label class="form-label ml-0 md:ml-4">STOK</label>
        <input type="number" name="stok" class="form-input"
               value="{{ old('stok', 0) }}" min="0" required>
    </div>
    <div class="form-group mb-0">
        <label class="form-label ml-0 md:ml-4">UNIT</label>
        <input type="text" name="unit" class="form-input"
               value="{{ old('unit', 'KG') }}" placeholder="KG">
    </div>
</div>