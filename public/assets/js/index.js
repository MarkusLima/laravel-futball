window.onload = fetData;

async function fetData() {
    const leagues = await getLeagues();
    //const teams = await getTeams();

    console.log(leagues)
    //console.log(teams)


    if (!leagues || !leagues.body || !leagues.body.competitions) {
        alert("Erro ao buscar as ligas.");
        return;
    }

    // if (!teams || !teams.body || !teams.body.teams) {
    //     alert("Erro ao buscar as times.");
    //     return;
    // }

    showSelect(leagues.body.competitions, "#league_id");

    //showSelect(teams.body.teams, "#team_id");
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
        const timeAway = games[index].awayTeam && games[index].awayTeam.shortName ? games[index].awayTeam.shortName : "----";
        const timeHome = games[index].homeTeam && games[index].homeTeam.shortName ? games[index].homeTeam.shortName : "----";

        const timeAwayScore = games[index].score && games[index].score.fullTime && games[index].score.fullTime.away ? games[index].score.fullTime.away : "----";
        const timeHomeScore = games[index].score && games[index].score.fullTime && games[index].score.fullTime.home ? games[index].score.fullTime.home : "----";

        const stage = games[index].stage ? games[index].stage : "----";

        const date = games[index].utcDate ? games[index].utcDate : "----";

        list += `<div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <h5 class="card-title">${timeAway} ${timeAwayScore} vs ${timeHomeScore} ${timeHome}</h5>
                            <p class="card-text">
                                <strong>Data:</strong>${stage}<br>
                                <strong>Local:</strong>${date}
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

async function getTeams() {

    try {
        const response = await fetch("/api/teams");
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
    console.log(gamesLeagues)

    if (!gamesLeagues || !gamesLeagues.body || !gamesLeagues.body.matches) {
        alert("Erro ao buscar os matches.");
        return;
    }
    showGamesBody(gamesLeagues.body.matches);
    
}

document.getElementById("show_games").addEventListener('click', showGames)
