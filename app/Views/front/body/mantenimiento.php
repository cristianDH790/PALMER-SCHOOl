<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página en Construcción | Palmer School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo-palmer.ico" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg,
                #ffffff 0%,
                #09acef 35%,
                #42ad22 70%,
                #094886 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 55px 35px;
            border-radius: 18px;
            text-align: center;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.25);
        }

        .logo {
            width: 140px;
            margin-bottom: 30px;
        }

        .title {
            color: #094886;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .description {
            color: #333;
            font-size: 17px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .description .highlight {
            display: inline-block;
            margin-top: 10px;
            color: #09acef;
            font-weight: 600;
            font-size: 18px;
        }

        .footer {
            font-size: 14px;
            font-weight: 600;
            color: #42ad22;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .title {
                font-size: 26px;
            }

            .logo {
                width: 120px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <img 
            src="https://palmerschool.cubicol.pe/img/escudo.png?c94e74142ab2d650bd1cdaca4aa5999e" 
            alt="Palmer School" 
            class="logo"
        >

        <h1 class="title">Página en construcción</h1>

        <p class="description">
            Estamos trabajando para ofrecerte una mejor experiencia.
            <br>
            <span class="highlight">Muy pronto estaremos en línea.</span>
        </p>

        <footer class="footer">
            © Palmer School
        </footer>
    </div>

</body>
</html>
