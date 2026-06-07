{{-- resources/views/tenant/stok/_form-restock.blade.php
     Partial: dipakai di desktop ($prefix='d') dan mobile ($prefix='m')
     $prefix digunakan untuk membedakan JS element ID antara dua form
──────────────────────────────────────────────────────────── --}}
@php $prefix ??= 'd'; @endphp

{{-- Nama Barang — Ditambah padding-left di tag select agar teks "Pilih barang..." bergeser ke kanan --}}
<div class="form-group mb-4">
    <label class="form-label" style="margin-left: 15px !important;">NAMA BARANG</label>
    <select name="barang_id" class="form-select" 
            style="padding-left: 20px !important; width: 100% !important;">
        <option>Pilih barang...</option>
        @foreach ($semuaBarang as $b)
        <option value="{{$b->barang_id}}">
            {{$b->nama}}
        </option>
        @endforeach
    </select>
</div>

{{-- Supplier  --}}
<div class="form-group">
    <label class="form-label" style="margin-left: 15px !important;">SUPPLIER</label>
    <input type="text" name="supplier_id" placeholder="Pilih supplier..."
    class="form-input" required>
</div>

{{-- Baris Jumlah & Unit  --}}
<div class="grid grid-cols-2 gap-4 mb-4">
    {{-- Jumlah --}}
    <div class="form-group">
        <label class="form-label" style="margin-left: 15px !important;">JUMLAH</label>
        <input type="number" name="jumlah" class="form-input" placeholder="0">
    </div>

    {{-- Unit --}}
    <div class="form-group">
        <label class="form-label" style="margin-left: 15px !important;">UNIT</label>
        <input type="text" name="unit" class="form-input" placeholder="KG">
    </div>
</div>

{{-- Harga Per Unit --}}
<div class="form-group">
    <label class="form-label" style="margin-left: 15px !important;">HARGA PER UNIT</label>
    <div class="input-prefix-wrap">
        <span class="input-prefix"> Rp </span>
        <input type="number" name="harga_per_unit"
               class="form-input has-prefix"
               value="{{ old('harga_jual') }}" placeholder="0" required>
    </div>
</div>

{{-- Nominal Diberikan  --}}
<div class="form-group">
    <label class="form-label" style="margin-left: 15px !important;">NOMINAL DIBERIKAN</label>
    <div class="input-prefix-wrap">
        <span class="input-prefix"> Rp </span>
        <input type="number" name="harga_per_unit"
               class="form-input has-prefix"
               value="{{ old('harga_jual') }}" placeholder="0" required>
    </div>
</div>

{{-- Metode bayar ke supplier: QRIS / TUNAI --}}
<div class="flex gap-2 mb-4">
    <button type="button" id="{{ $prefix }}RsBtnQRIS"
            class="restock-pay-btn flex flex-col gap-2" onclick="setRestockMetode('{{ $prefix }}', 'qris')">
        <i class="fa-solid fa-qrcode text-[15px]"></i>QRIS
    </button>
    
    <button type="button" id="{{ $prefix }}RsBtnTUNAI"
            class="restock-pay-btn active flex flex-col gap-2" onclick="setRestockMetode('{{ $prefix }}', 'tunai')">
        <i class="fa-solid fa-money-bill text-[15px]"></i> TUNAI
    </button>
</div>

<input type="hidden" name="metode_bayar" id="{{ $prefix }}RsMetode" value="tunai">

{{-- Ringkasan pembayaran supplier --}}
<div class="space-y-1.5 py-3 border-t border-b border-gray-100 text-sm mb-4">
    <div class="flex justify-between text-gray-500">
        <span>Subtotal</span><span id="{{ $prefix }}RsSubtotal">Rp 0</span>
    </div>
    <div class="flex justify-between font-bold text-gray-900 text-base">
        <span>Total</span>
        <span id="{{ $prefix }}RsTotal" style="color:var(--primary);">Rp 0</span>
    </div>
    {{-- Bayar --}}
    <div class="flex justify-between text-gray-500">
        <span>Bayar</span><span id="{{ $prefix }}RsBayar">Rp 0</span>
    </div>
    <div class="flex justify-between text-gray-500">
        <span>Kembali</span><span id="{{ $prefix }}RsKembali">Rp 0</span>
    </div>
    <div class="flex justify-between font-semibold">
        <span>Kurang</span>
        <span id="{{ $prefix }}RsKurang" style="color:var(--danger);">Rp 0</span>
    </div>
</div>
