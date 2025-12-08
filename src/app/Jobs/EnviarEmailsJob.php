<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\Cuenta;
use App\Models\MensajeProgramado;
use App\Models\EnvioResultado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

/**
 * Tiene que haber un crontab programado, que dispare EnviarMailsJob cada minuto
 * Los Mensajes, tienen tres estados 0-Sin iniciar, 1-Iniciado, 2-Terminado
 *
 *
 */

class EnviarEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private function mensajesProgramadosHoy() {
        $hoy = now()->toDateString();

        $mensajes = MensajeProgramado::whereDate('start_date', '<=', $hoy)
            ->whereDate('end_date', '>=', $hoy)
            ->where('estado', 0)
            ->get();

        $info = [
            'cantidad_mensajes_encontrados' => $mensajes->count()
        ];
        Log::info('EnviarMailsJob:', $info);

        return $mensajes;
    }


    private function enviarMensajeProgramado($mensaje) {
        $info = [
            'id' => $mensaje->id,
            'subject' => $mensaje->subject
        ];
        Log::info('Enviando Mensaje Programado:', $info);
    }

    public function handle()
    {

        // Get scheduled messages valid for today
        $mensajes = $this->mensajesProgramadosHoy();

        if ($mensajes->isNotEmpty()) {
            foreach($mensajes as $mensaje) {
                $this->enviarMensajeProgramado($mensaje);
            }
        }

        return;

        // Get active SMTP accounts
        $cuentas = Cuenta::where('activa', true)
                    ->with('SmtpConfig')
                    ->get();

        if ($cuentas->isEmpty()) {
            return;
        }

        // Get pending emails
        $emails = Email::where('enviado', false)->get();

        foreach ($emails as $email) {

            // Pick a random account
            $cuenta = $cuentas->random();

            try {
                // Sleep random time (1 to 6 seconds)
                sleep(rand(1, 6));

                // Configure SMTP dynamically
                config([
                    'mail.mailers.smtp.host' => $cuenta->smtp->host,
                    'mail.mailers.smtp.port' => $cuenta->smtp->puerto,
                    'mail.mailers.smtp.username' => $cuenta->nombre,
                    'mail.mailers.smtp.password' => $cuenta->password,
                    'mail.mailers.smtp.encryption' => $cuenta->smtp->encryption,
                    'mail.from.address' => $cuenta->nombre,
                    'mail.from.name' => $cuenta->nombre,
                ]);

                dd(json_encode($cuenta));

                // Send email
                Mail::raw($mensaje->cuerpo, function ($m) use ($email, $mensaje) {
                    $m->to($email->email)->subject($mensaje->subject);
                });

                // Mark email as sent
                $email->update(['enviado' => true]);

                // Log result
                EnvioResultado::create([
                    'email_id' => $email->id,
                    'cuenta_id' => $cuenta->id,
                    'resultado' => 'ok',
                    'programacion_id' => $mensaje->id,
                    'error_message' => null
                ]);

            } catch (\Exception $e) {

                // Log failed attempt
                EnvioResultado::create([
                    'email_id' => $email->id,
                    'cuenta_id' => $cuenta->id,
                    'resultado' => 'ok',
                    'programacion_id' => $mensaje->id,
                    'error_message' =>  $e->getMessage(),
                ]);
            }
        }
    }
}
