@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Meja #{{ $meja->nomor_meja }}</h4>
                    <a href="{{ route('mejas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Meja -->
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-table"></i> Informasi Meja</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Nomor Meja:</strong></td>
                                            <td><span class="badge bg-primary fs-6">{{ $meja->nomor_meja }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kapasitas:</strong></td>
                                            <td>{{ $meja->kapasitas }} orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($meja->status == 'tersedia')
                                                    <span class="badge bg-success">Tersedia</span>
                                                @elseif($meja->status == 'terisi')
                                                    <span class="badge bg-danger">Terisi</span>
                                                @else
                                                    <span class="badge bg-warning">Reserved</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Keterangan:</strong></td>
                                            <td>{{ $meja->keterangan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td>{{ $meja->created_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diperbarui:</strong></td>
                                            <td>{{ $meja->updated_at->format('d F Y, H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat Pesanan -->
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Riwayat Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    @if($meja->pesanans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Pelanggan</th>
                                                        <th>Menu</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($meja->pesanans->take(5) as $pesanan)
                                                    <tr>
                                                        <td>{{ $pesanan->created_at->format('d/m H:i') }}</td>
                                                        <td>{{ $pesanan->pelanggan->namapelanggan }}</td>
                                                        <td>{{ $pesanan->menu->namamenu }}</td>
                                                        <td>{{ $pesanan->jumlah }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($meja->pesanans->count() > 5)
                                            <small class="text-muted">Dan {{ $meja->pesanans->count() - 5 }} pesanan lainnya...</small>
                                        @endif
                                    @else
                                        <p class="text-muted">Belum ada pesanan untuk meja ini.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('mejas.edit', $meja) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Meja
                        </a>
                        <form method="POST" action="{{ route('mejas.destroy', $meja) }}" 
                              style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus Meja
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
