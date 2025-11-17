{{-- @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Ups!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    </script>
@endif --}}

<script>
    Livewire.on('message', (message) => {
        Swal.fire({
            icon: 'null',
            // title: 'Berhasil!',
            text: message,
            // timer: 1500,
            showConfirmButton: true,
        });
    });

    Livewire.on('show-success', (message) => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 2000,
            showConfirmButton: false,
        });
    });

    Livewire.on('show-error', (message) => {
        Swal.fire({
            icon: 'error',
            title: 'Ups!',
            text: message,
            showConfirmButton: true,
        });
    });
</script>


