<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Enzi Scholars') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --enzi-teal: #2C7A78;
                --enzi-gold: #D9A441;
                --enzi-cream: #FAF7F1;
                --enzi-charcoal: #2D2D2D;
            }

            body {
                font-family: 'Figtree', sans-serif;
            }

            .enzi-split {
                min-height: 100vh;
                display: flex;
            }

            .enzi-brand-panel {
                flex: 1;
                background: linear-gradient(160deg, var(--enzi-teal) 0%, var(--enzi-gold) 100%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 3rem;
                color: white;
                text-align: center;
            }

            .enzi-brand-panel img {
                max-width: 220px;
                margin-bottom: 1.5rem;
                border-radius: 12px;
                box-shadow: 0 12px 32px rgba(0,0,0,0.25);
            }

            .enzi-brand-panel h1 {
                font-weight: 700;
                font-size: 1.9rem;
                margin-bottom: 0.5rem;
                letter-spacing: 0.5px;
            }

            .enzi-brand-panel p {
                font-size: 1rem;
                opacity: 0.92;
                max-width: 320px;
            }

            .enzi-form-panel {
                flex: 1;
                background: var(--enzi-cream);
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 2rem;
            }

            .enzi-form-card {
                width: 100%;
                max-width: 420px;
                background: white;
                border-radius: 14px;
                box-shadow: 0 8px 28px rgba(44, 122, 120, 0.08);
                padding: 2.25rem;
                border: 1px solid rgba(44, 122, 120, 0.08);
            }

            @media (max-width: 767px) {
                .enzi-split {
                    flex-direction: column;
                }
                .enzi-brand-panel {
                    padding: 2rem 1.5rem;
                }
                .enzi-brand-panel img {
                    max-width: 140px;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="enzi-split">
            <div class="enzi-brand-panel">
                <a href="/">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Enzi Scholars">
                </a>
                <h1>Enzi Scholars</h1>
                <p>A New Era of Empowered Minds — Scholarship Registration &amp; Decision Support System</p>
            </div>

            <div class="enzi-form-panel">
                <div class="enzi-form-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>