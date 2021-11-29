<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<div>
    <p>Estimad@  {{ $meeting->asesorComercial->first_name }} {{ $meeting->asesorComercial->last_name }}, </p>

    <p>Le saluda {{ $meeting->bcAsesor->first_name }} {{ $meeting->bcAsesor->last_name }} de BC.
        Le recordamos que fue agendada una cita para el {{ $meeting->date_start  }} con el cliente Pedro Arcos a las 16:00.
        El PROSPECTO-91234 es cita fisica/normal y está dirigido para AGUIRRE ALEJANDRO.</p>

    <p>Me quedo pendiente de su atención 📲🚙 🤗</p>

    </div>
</body>
</html>
