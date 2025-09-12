<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <title>Wait</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>
    <style>
        body{display:flex;align-items:center;justify-content:center;min-height:100vh;}
    </style>
</head>
<body>
<div class="text-center">
    <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;"></div>
    <h5 class="mt-3">Wait</h5>
    <p class="text-muted">Please wait while we prepare your branch. This may take a while.</p>
</div>
<script>
    const statusUrl = '{{ $status_url }}';
    const redirectUrl = '{{ $redirect_url }}';
    async function poll(){
        try {
            const r = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
            if(!r.ok) throw new Error('HTTP '+r.status);
            const data = await r.json();
            if (Number(data.status) === 1) {
                window.location.href = redirectUrl;
                return;
            }
        } catch(e){ /* ignore */ }
        setTimeout(poll, 1500);
    }
    poll();
</script>
</body>
</html>
