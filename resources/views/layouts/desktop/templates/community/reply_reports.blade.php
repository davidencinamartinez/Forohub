@if ($reply_reports->isEmpty())
    <h2>No se han encontrado reportes de mensajes</h2>
@else
    <h2>Reportes de mensajes</h2>
    <div class="reply-reports-container">
    @foreach ($reply_reports as $reply_report)
        @if ($reply_report->solved == 0)
        <div class="reply-report unsolved" data-id="{{ $reply_report->id }}">
        @else
        <div class="reply-report solved" data-id="{{ $reply_report->id }}">
        @endif
            <div class="report-type">
                <label title="Mensaje">💬</label>
            </div>
            <div class="report-data">
                <label class="report-cause">{{ $reply_report->report_type }}</label>
                <label><b>Fecha: </b><label class="report-date">{{ $reply_report->created_at }}</label></label>
                <label><b>Enviado por: </b><a href="/u/{{ strtolower($reply_report->author->name) }}">{{ $reply_report->author->name }}</a></label>
                @if ($reply_report->solved == 0)
                <label><b>Estado: </b>Pendiente de revisión ❗</label>
                @else
                <label><b>Estado: </b>Resuelto ✔️</label>
                @endif
                <label><b>Fecha de vencimiento: </b>{{ date('d/m/Y (H:i)', strtotime($reply_report->created_at->addDays(30))) }}</label>
                @if ($reply_report->description)
                <label class="report-description"><b>Descripción: </b>{{ $reply_report->description }}</label>
                @endif
            </div>
            <div class="report-actions">
                <a href="/c/{{ $community->tag }}/t/{{ $reply_report->thread_id }}?pagina={{ $reply_report->page }}#{{ $reply_report->reply_id }}" target="_blank"><button>Ver Mensaje ↩️</button></a>
                @if ($reply_report->solved == 0)
                <button class="reply-solve">Marcar como resuelto ✔️</button>
                @endif
            </div>
        </div>
    @endforeach
    </div>
@endif