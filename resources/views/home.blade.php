<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campeonatos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h3 class="text-center mb-4">Escolha um Campeonato</h3>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulário -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/" method="GET" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Liga</label>
                        <select name="league_id" class="form-select" required>
                            @if (!empty($leagues['response']) && count($leagues['response']) > 0)
                                @foreach ($leagues['response'] as $league)
                                    <option value="{{ $league['league']['id'] }}">{{ $league['league']['name'] }}</option>
                                @endforeach
                            @else
                                <option disabled>Nenhuma liga disponível</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Temporada</label>
                        <input type="number" name="season" min="2000" max="2100" step="1"
                               value="{{ request('season', date('Y')) }}" class="form-control" required />
                    </div>

                    @if(!empty($times))
                        <div class="col-md-12">
                            <label class="form-label">Time</label>
                            <select name="team_id" class="form-select">
                                @foreach ($times as $time)
                                    <option value="{{ $time['id'] }}">{{ $time['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100">Ver Jogos</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Próximos Jogos -->
        @if(!empty($fixtures['response']) && count($fixtures['response']) > 0)
            <h2 class="mt-5">Próximos Jogos</h2>
            <div class="row">
                @foreach ($fixtures['response'] as $game)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $game['teams']['home']['name'] }} vs {{ $game['teams']['away']['name'] }}</h5>
                                <p class="card-text">
                                    <strong>Data:</strong> {{ date('d/m/Y H:i', strtotime($game['fixture']['date'])) }}<br>
                                    <strong>Local:</strong> {{ $game['fixture']['venue']['name'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!empty(request('season')))
            <div class="alert alert-warning text-center mt-4">Sem dados para exibir</div>
        @endif

        <!-- Últimos Resultados -->
        @if(!empty($results['response']) && count($results['response']) > 0)
            <h2 class="mt-5">Últimos Resultados</h2>
            <div class="row">
                @foreach ($results['response'] as $game)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $game['teams']['home']['name'] }} {{ $game['goals']['home'] }} x {{ $game['goals']['away'] }} {{ $game['teams']['away']['name'] }}</h5>
                                <p class="card-text">
                                    <strong>Local:</strong> {{ $game['fixture']['venue']['name'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(!empty(request('season')))
            <div class="alert alert-warning text-center mt-4">Sem dados para exibir</div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
