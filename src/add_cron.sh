#!/bin/bash

CRON_JOB="* * * * * /usr/bin/php /var/www/html/artisan schedule:run"

# Verifica si la línea ya existe
(crontab -l 2>/dev/null | grep -Fx "$CRON_JOB") >/dev/null
if [ $? -eq 0 ]; then
    echo "El cron ya existe. No se agrega."
    exit 0
fi

# Agregar al cron
( crontab -l 2>/dev/null; echo "$CRON_JOB" ) | crontab -

echo "Cron agregado correctamente."

