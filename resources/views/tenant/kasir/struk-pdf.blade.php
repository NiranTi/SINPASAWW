<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

@page{
    margin:12px;
}

body{
    margin:0;
    padding:3px;
    font-family:DejaVu Sans;
    font-size:10px;
}

h3{
    margin:0;
    padding:0;
}

p{
    margin:2px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:0;
}

.center{
    text-align:center;
}

</style>
</head>
<body>

<div class="center">
    <p>{{ $tenant->nama_tenant }}</p>
</div>

<hr>

<p>No. Transaksi :
{{ $transaksi->transaksi_id }}</p>

<p>
{{ $transaksi->created_at->format('d/m/Y H:i') }}
</p>

<hr>

@foreach($detail as $item)

<table>
<tr>
    <td>{{ $item->barang->nama }}</td>

    <td align="right">
        {{ $item->qty }} x
        {{ number_format($item->harga,0,',','.') }}
    </td>
</tr>


</table>

@endforeach

<hr>

<table>
<tr>
    <td>Subtotal</td>
    <td align="right">
        Rp {{ number_format($item->subtotal,0,',','.') }}
    </td>
</tr>

<tr>
    <td style="font-size:14px"><strong>Total</strong></td>

    <td align="right" style="font-size:14px">
        <strong>Rp {{ number_format($transaksi->total,0,',','.') }}</strong>
    </td>
</tr>

<tr>
    <td>Metode Pembayaran</td>

    <td align="right">
        {{strtoupper($transaksi->metode_bayar)}}
    </td>
</tr>

<tr>
    <td>Bayar</td>

    <td align="right">
        Rp {{ number_format($transaksi->jumlah_bayar,0,',','.') }}
    </td>
</tr>

<tr>
    <td>Kembali</td>

    <td align="right">
        Rp {{ number_format($transaksi->kembalian,0,',','.') }}
    </td>
</tr>

</table>

<hr>

<div class="center">
Terima Kasih
</div>

</body>
</html>
