@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Randevular</h5>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Yeni Randevu</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Başlık</th>
                                <th>Müşteri</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->title }}</td>
                                <td>
                                    {{ $appointment->client_name }}<br>
                                    <small>{{ $appointment->client_phone }}</small>
                                </td>
                                <td>{{ $appointment->appointment_date->format('d.m.Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-warning">Düzenle</a>
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Emin misiniz?')">Sil</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 