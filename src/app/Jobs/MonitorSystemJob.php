<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MonitorSystemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Información básica del servidor
        $memoryUsage = memory_get_usage(true);
        $peakMemory = memory_get_peak_usage(true);
        $cpuLoad = sys_getloadavg(); // [1 min, 5 min, 15 min]

        // Información de Laravel
        $queueSize = \DB::table('jobs')->count();
        $failedJobs = \DB::table('failed_jobs')->count();

        // Crear un arreglo con toda la info
        $info = [
            'timestamp'      => now()->toDateTimeString(),
            'memory_usage_mb' => round($memoryUsage / 1024 / 1024, 2),
            'peak_memory_mb'  => round($peakMemory / 1024 / 1024, 2),
            'cpu_load'        => $cpuLoad,
            'queue_size'      => $queueSize,
            'failed_jobs'     => $failedJobs,
        ];

        // Guardar en logs
        Log::info('Monitor del sistema:', $info);
    }
}
