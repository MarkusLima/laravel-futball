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
        <!-- Formulário -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Campeonatos</label>
                        <select name="league_id" class="form-select" id="league_id">
                            <option value="">--select--</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Times</label>
                        <select name="team_id" class="form-select" id="team_id">
                            <option value="">--select--</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary w-100" id="show_games">Ver Jogos</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header"><label>Jogos</label></div>
            <div class="card-body">
                <div class="row" id="list_games">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/assets/js/index.js') }}"></script>
</body>
</html>
