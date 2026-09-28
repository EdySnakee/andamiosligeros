@extends('layouts.app_redes')

@section('css')
    <style>
        .logs-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 21px 21px 8px;
        }

        .logs-title {
            margin: 0;
            font-weight: 500;
            letter-spacing: -.02em;
        }

        .logs-search {
            max-width: 360px;
            width: 100%;
        }

        .logs-search input {
            width: 100%;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .12);
            padding: 10px 12px;
            outline: none;
            transition: box-shadow .15s ease, border-color .15s ease;
            background: #fff;
        }

        .logs-search input:focus {
            border-color: rgba(37, 99, 235, .45);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .logs-card {
            border: 1px solid rgba(15, 23, 42, .10);
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
        }

        .table-logs {
            margin: 0;
        }

        .table-logs thead th {
            background: #f8fafc;
            color: #0f172a;
            font-size: 12px;
            letter-spacing: .12em;
            text-transform: uppercase;
            font-weight: 900;
            border-bottom: 1px solid rgba(15, 23, 42, .10) !important;
            white-space: nowrap;
        }

        .table-logs tbody td {
            vertical-align: middle;
            color: #111827;
            font-size: 14px;
        }

        .badge-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .badge-login {
            background: rgba(22, 163, 74, .10);
            color: #166534;
            border-color: rgba(22, 163, 74, .20);
        }

        .badge-logout {
            background: rgba(245, 158, 11, .12);
            color: #92400e;
            border-color: rgba(245, 158, 11, .24);
        }

        .badge-other {
            background: rgba(37, 99, 235, .10);
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, .20);
        }

        .muted {
            color: #6b7280;
            font-size: 12px;
        }

        .ua {
            max-width: 420px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination {
            margin-top: 14px;
        }
    </style>
@stop

@section('content')
    <div class="logs-header">
        <h1 class="logs-title">Registros de actividad</h1>

        <div class="logs-search">
            <input id="logsSearch" type="text" placeholder="Buscar por email, IP, acción, agente...">
        </div>
    </div>

    @if (isset($logs) && $logs->count())
        <div class="logs-card">
            <div class="table-responsive">
                <table class="table table-hover table-logs" id="logsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Dirección IP</th>
                            <th>Agente o navegador</th>
                            <th>Fecha y hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            @php
                                $action = strtolower($log->action ?? '');
                                $badgeClass =
                                    $action === 'login'
                                        ? 'badge-login'
                                        : ($action === 'logout'
                                            ? 'badge-logout'
                                            : 'badge-other');
                            @endphp
                            <tr>
                                <td class="muted">{{ $log->id }}</td>
                                <td>
                                    <div style="font-weight:800;">
                                       {{ $log->user ? $log->user->email : '—' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-action {{ $badgeClass }}">
                                        {{ ucfirst($action ?: 'accion') }}
                                    </span>
                                </td>
                                <td style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
                                    {{ $log->ip_address }}
                                </td>
                                <td class="ua" title="{{ $log->user_agent }}">
                                    {{ \Illuminate\Support\Str::limit($log->user_agent, 90) }}
                                </td>
                                <td class="muted">
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $logs->links() }}
    @else
        <div class="logs-card" style="padding:16px;">
            <p style="margin:0;">No hay registros para mostrar.</p>
        </div>
    @endif
@stop

@section('js')
    <script>
        (function() {
            const input = document.getElementById('logsSearch');
            const table = document.getElementById('logsTable');
            if (!input || !table) return;

            input.addEventListener('input', function() {
                const q = this.value.toLowerCase().trim();
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(tr => {
                    const text = tr.innerText.toLowerCase();
                    tr.style.display = text.includes(q) ? '' : 'none';
                });
            });
        })();
    </script>
@stop
