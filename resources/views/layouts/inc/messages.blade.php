<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "5000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>
@if(session('success'))
    <script>
        $(function() {
            toastr.success('{{ session("success") }}')
        });
    </script>
@endif
@if(session('error'))
    <script>
        $(function() {
            toastr.error('{{ session("error") }}')
        });
    </script>
@endif
@if(session('warning'))
    <script>
        $(function() {
            toastr.warning('{{ session("warning") }}')
        });
    </script>
@endif
@if(session('info'))
    <script>
        $(function() {
            toastr.info('{{ session("info") }}')
        });
    </script>
@endif

