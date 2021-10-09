@if(isset($isLogin) && $isLogin == false)
    <script type="text/javascript">
        function getHost() {
            return '{{ env('APP_URL') }}{{ $isMobile == true ? '/sp' : '' }}';
        }

        function getSpHost() {
            return '{{ env('APP_URL') }}/sp';
        }

        function getLoginHost() {
            return '{{ env('APP_URL') }}';
        }
    </script>
    <script type="text/javascript">
        $(function() {
            var ownDomain = String(window.location);
            if (ownDomain.indexOf("control.xaas.jp") == -1) {
                $.getScript("/assets/js/eparkLoginCheck.js");
            }
        });
    </script>
@endif