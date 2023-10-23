@if (session('success_message') || session('info_message')
|| session('warning_message') || session('error_message'))
    <script type="text/javascript">
        $(() => {
            @if ($message = session('success_message')) toastr.success('{{ $message }}'); @endif
            @if ($message = session('info_message')) toastr.info('{{ $message }}'); @endif
            @if ($message = session('warning_message')) toastr.warning('{{ $message }}'); @endif
            @if ($message = session('error_message')) toastr.error('{{ $message }}'); @endif
        });
    </script>
@endif
