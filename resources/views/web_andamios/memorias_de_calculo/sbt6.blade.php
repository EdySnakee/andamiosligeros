@extends('layouts.web_andamios')
@section('css')
<title>Memoria de Cálculo SBT-6 | Andamios Ligeros</title>
<meta name="description" content="Consulta la memoria de cálculo y análisis estructural del andamio modelo SBT-6. Seguridad y calidad garantizada." />
<meta name="keywords" content="memoria de calculo, SBT-6, andamios, seguridad, construccion, analisis estructural" />

<style>
    :root {
        --brand-blue: #0948AF;
        --brand-accent: #00bcd4;
        --gray-bg: #f8f9fa;
    }

    .memory-section {
        padding: 60px 0;
        background: var(--gray-bg);
        min-height: 90vh;
    }

    .memory-container {
        max-width: 1100px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        border-top: 6px solid var(--brand-blue);
    }

    .memory-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .memory-header h1 {
        color: var(--brand-blue);
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .memory-header .divider {
        width: 60px;
        height: 4px;
        background: var(--brand-accent);
        margin: 0 auto 20px;
        border-radius: 2px;
    }

    .pdf-wrapper {
        position: relative;
        width: 100%;
        height: 800px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .pdf-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .actions {
        margin-top: 30px;
        text-align: center;
    }

    .btn-download {
        background: var(--brand-blue);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-download:hover {
        background: #052c6d;
        transform: translateY(-2px);
        color: white;
    }

    @media (max-width: 767px) {
        .memory-container {
            padding: 20px;
        }

        .memory-header h1 {
            font-size: 1.8rem;
        }

        .pdf-wrapper {
            height: 500px;
        }
    }
</style>
@stop

@section('content')
<main class="page-normal">
    <section class="memory-section">
        <div class="container">
            <div class="memory-container">
                <div class="memory-header">
                    <h1>Memoria de Cálculo SBT-6</h1>
                    <div class="divider"></div>
                    <p>Documento técnico de análisis estructural y seguridad para el modelo SBT-6.</p>
                </div>

                <div class="pdf-wrapper">
                    <!-- Placeholder para el PDF del SBT-6 -->
                    <iframe src="{{ url('memorias_calculo/memoria-de-calculo-sbt6.pdf') }}"></iframe>
                </div>
            </div>
        </div>
    </section>
</main>
@stop

@section('js')
@stop