<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Voedselpakketten</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                background: #5C5C5C;
                color: #1b1b18;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                min-height: 100vh;
                margin: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .container {
                background: #fff;
                border-radius: 1rem;
                box-shadow: 0 4px 24px rgba(0,0,0,0.08);
                padding: 2.5rem 2rem;
                max-width: 420px;
                width: 100%;
                text-align: center;
            }
            h1 {
                color: #000;
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }
            .accent {
                color: #18B5FE;
            }
            .subtitle {
                color: #5C5C5C;
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }
            .button {
                background: #18B5FE;
                color: #fff;
                border: none;
                border-radius: 0.5rem;
                padding: 0.9rem 2.2rem;
                font-size: 1.1rem;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.2s;
                text-decoration: none;
                display: inline-block;
                margin-top: 1.5rem;
                box-shadow: 0 2px 8px rgba(24,181,254,0.08);
            }
            .button:hover {
                background: #1293c7;
            }
            .footer {
                margin-top: 2.5rem;
                color: #5C5C5C;
                font-size: 0.95rem;
            }
            @media (max-width: 500px) {
                .container {
                    padding: 1.2rem 0.5rem;
                }
                h1 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container text-black">
            <h1>
                Welkom bij <span class="accent">Voedselpakketten</span>
            </h1>
            <div class="subtitle">
                Beheer eenvoudig voedselpakketten en klanten.<br>
                Start direct met het overzicht!
            </div>
            <a href="" class="button">
                Naar overzicht
            </a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Voedselpakketten | Gemaakt met Laravel
        </div>
    </body>
</html>