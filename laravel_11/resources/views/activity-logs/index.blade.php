@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Aktivite Logları</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Kullanıcı</th>
                                <th>Olay</th>
                                <th>Model</th>
                                <th>Değişiklikler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                                <td>{{ $log->causer->name ?? 'Sistem' }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</td>
                                <td>
                                    @if($log->properties->count() > 0)
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                            Detaylar
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Değişiklik Detayları</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($log->properties->has('attributes'))
                                                            <h6>Yeni Değerler:</h6>
                                                            <pre>{{ json_encode($log->properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                        @endif
                                                        
                                                        @if($log->properties->has('old'))
                                                            <h6>Eski Değerler:</h6>
                                                            <pre>{{ json_encode($log->properties['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Değişiklik yok</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 