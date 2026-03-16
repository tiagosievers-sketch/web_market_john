<div class="container mt-5">
    <div class="alert alert-success">
        {{ __('Agent registered successfully! Redirecting to login...') }}
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "{{ route('login') }}";
        }, 3000); // Redireciona em 3 segundos
    </script>
</div>
