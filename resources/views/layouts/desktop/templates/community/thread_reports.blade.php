@if ($thread_reports->isEmpty())
    <h2>No se han encontrado reportes de temas</h2>
@else
    <h2>Reportes de temas</h2>
    <div class="thread-reports-container">
    @foreach ($thread_reports as $thread_report)
        @if ($thread_report->solved == 0)
        <div class="thread-report unsolved" data-id="{{ $thread_report->id }}">
        @else
        <div class="thread-report solved" data-id="{{ $thread_report->id }}">
        @endif
            <div class="report-type">
                <label title="Tema">📝</label>
            </div>
            <div class="report-data">
                <label class="report-cause">{{ $thread_report->report_type }}</label>
                <label><b>Fecha: </b><label class="report-date">{{ $thread_report->created_at }}</label></label>
                <label><b>Enviado por: </b><a href="/u/{{ strtolower($thread_report->author->name) }}">{{ $thread_report->author->name }}</a></label>
                @if ($thread_report->solved == 0)
                <label><b>Estado: </b>Pendiente de revisión ❗</label>
                @else
                <label><b>Estado: </b>Resuelto ✔️</label>
                @endif
                <label><b>Fecha de vencimiento: </b>{{ date('d/m/Y (H:i)', strtotime($thread_report->created_at->addDays(30))) }}</label>
                @if ($thread_report->description)
                <label class="report-description"><b>Descripción: </b>{{ $thread_report->description }}</label>
                @endif
            </div>
            <div class="report-actions">
                <a href="/c/{{ $community->tag }}/t/{{ $thread_report->thread_id }}"><button>Ver Tema ↩️</button></a>
                @if ($thread_report->solved == 0)
                <button class="thread-solve">Marcar como resuelto ✔️</button>
                @endif
            </div>
        </div>
    @endforeach
    </div>
@endif