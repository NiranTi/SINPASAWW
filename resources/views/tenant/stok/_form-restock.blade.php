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
    <input type="number" name="harga_per_unit" class="form-input" placeholder="Rp 0" required>
</div>

{{-- Nominal Diberikan  --}}
<div class="form-group">
    <label class="form-label" style="margin-left: 15px !important;">NOMINAL DIBERIKAN</label>
    <input type="number" name="nominal_diberikan" class="form-input" placeholder="Rp 0" required>
</div>

{{-- Metode bayar ke supplier: QRIS / TUNAI --}}
<div class="flex gap-2 mb-4">
    <button type="button" id="{{ $prefix }}RsBtnQRIS"
            class="restock-pay-btn" onclick="setRestockMetode('{{ $prefix }}', 'qris')">
        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1 -1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 14.25h3v3h-3v-3ZM16.5 17.25h3v3h-3v-3ZM19.5 14.25h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM16.5 14.25h.75v.75h-.75v-.75ZM19.5 18h.75v.75h-.75v-.75ZM18 15.75h.75v.75h-.75v-.75ZM15.75 18h.75v.75h-.75v-.75Z" />
        </svg>
        QRIS
    </button>
    
    <button type="button" id="{{ $prefix }}RsBtnTUNAI"
            class="restock-pay-btn active" onclick="setRestockMetode('{{ $prefix }}', 'tunai')">
        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 0 1 1.5 1.5v11.25a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V6.5a1.5 1.5 0 0 1 1.5-1.5Zm6.45 7.5a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0Z" />
        </svg>
        TUNAI
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
