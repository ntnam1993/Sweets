<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="viewport" name="viewport" content="" />
        <link rel="canonical" href="{{ request()->url() }}" />
        <style type="text/css">
            table.content tr td:first-child {
                border-right: 1px solid #bdbdbd;
                padding-right: 15px;
                padding-bottom: 15px;
                text-align: right;
                vertical-align: top;
            }
            table.content tr td:last-child {
                padding-left: 15px;
                vertical-align: top;
            }
            table.content p {
                margin: 0;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>
</html>
