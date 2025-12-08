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
use App\Mail\Notificacion;

/**
 * Tiene que haber un crontab programado, que dispare EnviarMailsJob cada minuto
 * Los Mensajes, tienen tres estados 0-Sin iniciar, 1-Iniciado, 2-Terminado
 * Las cuentas tienen un indicador de enviados, que no debe superar los 450.
 * Cuando alcanzan los 450, pasa a desabilitado, y se registra la fecha.
 * Con esa fecha, cada vez que se consulta, si han pasado 24, se vuelve a
 * habilitar, se pone ne 0 y se anula fecha
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

    public function handle()
    {
        Email::query()->update(['enviado' => 0]);
        // Get scheduled messages valid for today
        $mensajes = $this->mensajesProgramadosHoy();

        if ($mensajes->isNotEmpty()) {
            foreach($mensajes as $mensaje) {
                $this->enviarMensajeProgramado($mensaje);
            }
        }
    }


    private function getActiveCount() {
        // Get active SMTP accounts
        $cuentas = Cuenta::where('activa', true)
                    ->where('envios', '<', 450)
                    ->with('SmtpConfig')
                    ->orderBy('envios')
                    ->get();

        // Encontre una cuenta en condiciones
        if ($cuentas->count() > 0) {
            $cuenta = $cuentas->first();
            return $cuenta;
        }

        $cuentas = Cuenta::where('activa', true)
        ->where('fecha_bloqueo', '<', 450)
        ->with('SmtpConfig')
        ->orderBy('envios')
        ->get();

        // Recupero la cuenta con fecha de bloqueo mas vieja
        $cuenta = Cuenta::where('estado', 'activo')
                 ->whereNotNull('fecha_bloqueo')
                 ->with('SmtpConfig')
                 ->orderBy('fecha_bloqueo')
                 ->first();


        if ($cuenta->fecha_bloqueo && $cuenta->fecha_bloqueo->addHours(24)->lt(now())) {
        // Ya pasaron las 24 horas desde el bloqueo
            $cuenta->fecha_bloqueo = null;
            $cuenta->envios = 0;
            $cuenta->save();
            return $cuenta;
        }

        Log::error('No hay cuentas disponibles', []);
        return null;
    }

    private function actualizaCuentaEnvios($cuenta) {
        $cuenta->envios++;
        if ($cuenta->envios == 450) {
            $cuenta->fecha_bloqueo = now();
        }
        $cuenta->save();
    }

    private function configurarSMTP($cuenta) {
        config([
            'mail.mailers.smtp.host' => $cuenta->SmtpConfig->host,
            'mail.mailers.smtp.port' => $cuenta->SmtpConfig->port,
            'mail.mailers.smtp.username' => $cuenta->nombre,
            'mail.mailers.smtp.password' => $cuenta->password,
            'mail.mailers.smtp.encryption' => $cuenta->SmtpConfig->encryption,
            'mail.from.address' => $cuenta->nombre,
            'mail.from.name' => $cuenta->nombre,
        ]);
        app()->forgetInstance('mailer');
        app()->make('mailer');
    }

    private function enviarMensajeProgramado($mensaje) {
        $info = [
            'id' => $mensaje->id,
            'subject' => $mensaje->subject
        ];
        Log::info('Enviando Mensaje Programado:', $info);



        // Get pending emails
        $emails = Email::where('enviado', false)->get();
        $info = ['cantidad.emails' => $emails->count()];
        Log::info('Cantidad de emails', $info);

        foreach ($emails as $email) {
            // Este ciclo puede repetirse por horas, hasta conseguir una cuenta
            do {
                $cuenta = $this->getActiveCount();
            } while ($cuenta == null);

            $this->actualizaCuentaEnvios($cuenta);
            Log::info('Cuenta de envio', $cuenta->toArray());

            $this->configurarSMTP($cuenta);

            try {
                // Sleep random time (1 to 6 seconds)
                sleep(rand(1, 6));

                $info = [
                            'email' => $email->email,
                            'from' => $cuenta->nombre
                        ];
                Log::info('Enviando mensaje a :', $info);

                try {
                    Mail::to($email->email)->send(new Notificacion($mensaje->body, $mensaje->subject));
                    $email = Email::find($email->id);
                    $email->enviado = 1;
                    $email->save();
                    Log::info('Enviado:', ['resultado' => 'ok', 'email' => $email]);
                } catch (\Exception $e) {
                    Log::error('Enviado:', ['resultado' => $e->getMessage()]);
                }

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
