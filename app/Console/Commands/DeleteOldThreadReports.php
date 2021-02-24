<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReportThread;
use Carbon\Carbon;

class DeleteOldThreadReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteThreadReports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all thread reports older than 30 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ReportThread::where('created_at', '<=', Carbon::now()->subSeconds(30))->delete();
        echo "Se ha ejecutado el comando 'deleteThreadReports' con éxito";
    }
}
