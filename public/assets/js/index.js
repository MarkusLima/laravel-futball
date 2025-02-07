window.onload = fetData;

async function fetData() {
    const leagues = await getLeagues();

    if (!leagues || !leagues.body) {
        alert("Erro ao buscar as ligas.");
        return;
    }

    showSelect(leagues.body, "#league_id");
}

async function changeSelectCompetition() {

    const competitionId = document.querySelector("#league_id").value;
    if (!competitionId) return;

    const teams = await getTeams(competitionId);

    if (!teams || !teams.body) {
        alert("Erro ao buscar as times.");
        return;
    }

    showSelect(teams.body, "#team_id");
}

function showSelect(body, element) {
    try {
        
        const selectElement = document.querySelector(element);
    
        let select = "<option value=''>--select--</option>";
    
        selectElement.innerHTML = "";
    
        for (let index = 0; index < body.length; index++) {
            select += `<option value="${body[index].id}">${body[index].name}</option>`;
        }
    
        selectElement.innerHTML = select;

    } catch (error) {
        console.error(error);
    }
}

function showGamesBody(games) {
    const listElement = document.querySelector("#list_games");

    let list = "";

    listElement.innerHTML = "";

    for (let index = 0; index < games.length; index++) {
        const timeAway = games[index].time_fora ? games[index].time_fora : "----";
        const timeHome = games[index].time_casa ? games[index].time_casa : "----";

        const timeAwayScore = games[index].placar && games[index].placar.time_fora ? games[index].placar.time_fora : "0";
        const timeHomeScore = games[index].placar && games[index].placar.time_casa ? games[index].placar.time_casa : "0";

        const stage = games[index].estadio ? games[index].estadio : "----";

        const date = games[index].data ? games[index].data : "----";

        list += `<div class="col-md-3 col-lg-3">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title"> ${timeAway} ${timeAwayScore} vs ${timeHomeScore} ${timeHome} </h5>
                            <p class="card-text">
                                <strong>Local:</strong> ${stage} <br>
                                <strong>Data:</strong> ${date}
                            </p>
                        </div>
                    </div>
                </div>`;
    }

    listElement.innerHTML = list;
}

async function getLeagues() {

    try {
        const response = await fetch("/api/leagues");
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getTeams(competitionId) {

    try {
        const response = await fetch("/api/teams?competitionId="+competitionId);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function getGamesLeagues(leagueCode, teamCode) {

    try {
        const response = await fetch("/api/results?leagueCode="+leagueCode+"&teamCode="+teamCode);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error);
        return null;
    }
}

async function showGames() {

    const leagueValue = document.querySelector("#league_id").value;
    const teamValue = document.querySelector("#team_id").value;

    if (!leagueValue && !teamValue) alert("Prezado, por favor selecione um campeonato ou time para sua pesquisa");

    const gamesLeagues = await getGamesLeagues(leagueValue, teamValue);

    if (!gamesLeagues || !gamesLeagues.body) {
        alert("Erro ao buscar os matches.");
        return;
    }
    showGamesBody(gamesLeagues.body);
    
}

document.getElementById("show_games").addEventListener('click', showGames);
document.getElementById("league_id").addEventListener('change', changeSelectCompetition);
