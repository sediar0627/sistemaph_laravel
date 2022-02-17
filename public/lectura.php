<!DOCTYPE HTML>
<html>

<HEAD>
    <TITLE>Ethernet Monitor</TITLE>
</HEAD>

<BODY>
    <script src='https://code.jquery.com/jquery-2.2.4.min.js' integrity='sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=' crossorigin='anonymous'></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'http://127.0.0.1/laravel_sitemaph/public/procesar_lectura.php?uuid_piscina=hola&lectura=7.6',
                type: 'GET',
                success: function(res) {
                    console.log(res);
                },
                error: function(err) {
                    console.warn(err);
                },
            });
        });
    </script>
</BODY>
