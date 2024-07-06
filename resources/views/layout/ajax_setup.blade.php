@push('script')
        <script>
            $(document).ready(function () {
                var csrfToken = '{{ csrf_token() }}';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            });
        </script>
@endpush