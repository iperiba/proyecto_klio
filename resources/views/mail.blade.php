<?php
setlocale(LC_TIME,"es_ES");
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tickets</title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700|Kreon:700|Audiowide&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <style>
        body {
            margin: 0;
            color: #ffffff;
            /*color: black;*/
            font-family: "Open Sans", sans-serif;
            font-weight: 400;
            font-size: 25px;
        }

        .container {
            width: 795px;
            margin: 0 auto;
        }

        section {
            position: relative;
            height: 280px;
            width: 100%;
            /*background-image: url(https://htmlpdfapi.com/uploads/images/568b96887261690f6dbe0000/content_background-concert-3.jpg?1451988615);*/
            background-image: url({{ $message->embed('images/dark_cinema.jpg') }});
            /*background-image: url({{ url('images/dark_cinema.jpg') }});*/
            background-repeat: no-repeat;
            overflow: hidden;
            margin-bottom: 20px;
        }
        section .left {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            float: left;
            width: 635px;
            padding: 35px 0 0 60px;
        }
        section .right {
            float: right;
            width: 160px;
            padding-top: 30px;
        }
        section .event {
            margin-bottom: 10px;
            /*margin-bottom: 40px;*/
            font-weight: 700;
            font-size: 25px;
            line-height: 35px;
            text-transform: uppercase;
            color: white;
        }
        section .title {
            margin-bottom: 15%;
            margin-top: 10px;
            color: #F5A623;
            /*font-family: "Audiowide", cursive;*/
            font-family:  Impact, Charcoal, sans-serif;
            font-size: 40px;
            line-height: 50px;
            transform: scaleY(0.9);
        }
        section .info {
            font-size: 20px;
            text-transform: uppercase;
            color: white;
        }
        section .seats {
            margin-bottom: 25px;
            font-size: 0.36em;
            text-transform: uppercase;
            text-align: right;
            color: white;
        }
        section .seats:last-child {
            margin-bottom: 0;
        }
        section .seats span {
            display: inline-block;
            width: 80px;
            margin-left: 15px;
            /*padding: 10px 0;*/
            color: #F5A623;
            background: rgba(255,255,255,0.17);
            font-family: "Kreon", serif;
            font-size: 20px;
            text-align: center;
            vertical-align: middle;
        }

        .apartado {
            font-size: 15px !important;
        }
    </style>
</head>

<body>
<div class="container">
    <?php
        foreach ($array_ticket as $ticket) {
    ?>

        <section>
            <div class="left">
                <div class="event">{{$ticket->tipo_entrada}}€</div>
                <div class="title">{{$datos_sesion->titulo}}</div>
                <!--<div class="info">{{$datos_sesion->fecha}}</div>-->
                <div class="info">
                    <?php
                        setlocale(LC_TIME,"es_ES");
                        $fecha_date = new DateTime($datos_sesion->fecha);
                        echo strftime("%A %e %B %Y / %I:%M",strtotime($datos_sesion->fecha));
                    ?>
                </div>
            </div>
            <div class="right">
                <div class="seats"><span class="apartado">Sala</span><span>{{$datos_sesion->codigo_sala}}</span></div>
                <div class="seats"><span class="apartado">Fila</span><span>{{$ticket->fila}}</span></div>
                <div class="seats"><span class="apartado">Butaca</span><span>{{$ticket->butaca}}</span></div>
            </div>
        </section>

    <?php
        }
    ?>

</div>
</body>

</html>
