const AK = "f600a9f1ba6c7530d4edc84dfb8c8a6f";
const language = "it-IT";
const genres_correspondance = {
    28: "azione",
    12: "avventura",
    16: "animazione",
    35: "commedia",
    80: "crime",
    99: "documentario",
    18: "drammatico",
    10751: "family",
    14: "fantasy",
    36: "storico",
    27: "horror",
    10402: "musical",
    9648: "mistero",
    10749: "romantico",
    878: "fantascienza",
    10770: "fiction",
    53: "thriller",
    10752: "guerra",
    37: "western"
}
var timesClicked = 0;
var userInput = "";
var userSearch = "";
var userYear = "";
var add_clicked = false;
function print(e)
{
    console.log(e);
}

function resetImage1()
{
    document.getElementById("poster_img").setAttribute("src", "");
    document.getElementById("coverImage").style.border = "1px dashed white";
    document.getElementById("poster_img").style.display = "none";
    document.getElementById("labelII").value = "";
}


function reset_() 
{
    resetImage1();
    document.getElementById("label_rating").innerHTML = "2.5/5";
    userInput = "";
    userSearch = "";
    timesClicked = 0;
    userYear = "";
    
    document.getElementById("btn_nonvisto").style.color = "black";
    document.getElementById("btn_nonvisto").style.backgroundColor = "var(--mainColor)";
    document.getElementById("btn_nonvisto").style.borderColor = "var(--mainColor)";

    document.getElementById("btn_visto").style.color = "black";
    document.getElementById("btn_visto").style.backgroundColor = "var(--mainColor)";
    document.getElementById("btn_visto").style.borderColor = "var(--mainColor)";

    nonvistoClick();
}

function vistoClick()
{
    mainForm.radio_visto_nonvisto.value = "visto";

    document.getElementById("inputRating").removeAttribute("disabled");
    document.getElementById("label_rating").style.display = "";

    document.getElementById("btn_nonvisto").style.color = "black";
    document.getElementById("btn_nonvisto").style.backgroundColor = "var(--mainColor)";
    document.getElementById("btn_nonvisto").style.borderColor = "var(--mainColor)";

    document.getElementById("btn_visto").style.color = "white";
    document.getElementById("btn_visto").style.backgroundColor = "var(--secondColor)";
    document.getElementById("btn_visto").style.borderColor = "var(--secondColor)";
}

function nonvistoClick()
{
    mainForm.radio_visto_nonvisto.value = "non_visto";

    document.getElementById("inputRating").setAttributeNode(document.createAttribute("disabled"));
    document.getElementById("label_rating").style.display = "none";

    document.getElementById("btn_nonvisto").style.color = "white";
    document.getElementById("btn_nonvisto").style.backgroundColor = "var(--secondColor)";
    document.getElementById("btn_nonvisto").style.borderColor = "var(--secondColor)";

    document.getElementById("btn_visto").style.color = "black";
    document.getElementById("btn_visto").style.backgroundColor = "var(--mainColor)";
    document.getElementById("btn_visto").style.borderColor = "var(--mainColor)";
}

function test()
{
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = gestisciResponse;
    httpRequest.open("GET", "https://api.themoviedb.org/3/search/movie?api_key=f600a9f1ba6c7530d4edc84dfb8c8a6f&language=it-IT&query=il%20gladiatore&page=1&include_adult=false&year=2000", true);
    httpRequest.send();
}

function gestisciResponse(e)
{
    if (e.target.readyState == 4 && e.target.status == 200) {
        document.getElementById("inputDescription").innerHTML
        = e.target.responseText;
        }
}

function autoCompile()
{
     // This product uses the The Movie Database API (www.themoviedb.org), but is not endorsed or certified by TMDb.

    var name = document.getElementById("inputName")
    var title = userInput;

    // title = "spiderman";

    if (title == "")
    {
        name.style.border = "1px solid red";
        return;
    }
    else
        name.style.border = "";

    if (timesClicked > 0)
        userYear = "";
    
    var base_url = "https://api.themoviedb.org/3/search/movie";
    var query = encodeURIComponent(title);
    var page = 1;
    var include_adult = false;
    var year = userYear;

    var url = 
        base_url +
        "?" +
        "api_key=" + AK + "&" +
        "language=" + language + "&" +
        "query=" + query + "&" +
        "page=" + page + "&" +
        "include_adult=" + include_adult + "&" +
        "year=" + year;

    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = gestisciListaFilm;
    httpRequest.open("GET", url, true);
    httpRequest.send();
}

function gestisciListaFilm(e)
{
    if (e.target.readyState == 4 && e.target.status == 200)
    {
        var data = JSON.parse(e.target.responseText);

        var base_url = "https://api.themoviedb.org/3/movie/";
        if (userInput != userSearch || userSearch == "")
        {
            timesClicked = 0;
            userSearch = userInput;
        }
        else
            timesClicked++;
        print(timesClicked);
        var id = data.results[timesClicked].id;
        var url = base_url + id + "?api_key=" + AK + "&language=" + language;

        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = gestisciFilm;
        httpRequest.open("GET", url, true);
        httpRequest.send();
        
    }
}

function gestisciFilm(e)
{
    if (e.target.readyState == 4 && e.target.status == 200)
    {
        var result = JSON.parse(e.target.responseText);

        document.getElementById("inputName").value = result.title;
        document.getElementById("inputYear").value = result.release_date.split("-")[0];
        document.getElementById("inputTime").value = result.runtime;
        document.getElementById("inputDescription").value = result.overview;
        if (result.genres.length > 0)
            document.getElementById("inputGenere").value = genres_correspondance[result.genres[0]["id"]];
        document.getElementById("posterImage").value = "https://image.tmdb.org/t/p/original" + result.poster_path;
        document.getElementById("backdropImage").value = "https://image.tmdb.org/t/p/original" + result.backdrop_path;
        
        // setting img 1 on screen
        resetImage1();
        if (result.poster_path != null)
        {
            document.getElementById("poster_img").setAttribute("src", "https://image.tmdb.org/t/p/original" + result.poster_path);
            document.getElementById("coverImage").style.border = "0px";
            document.getElementById("poster_img").style.display = "inline";
        }
        
        var base_url = "https://api.themoviedb.org/3/movie/";
        url = base_url + result.id + "/credits" + "?api_key=" + AK + "&language=" + language;

        var httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = gestisciFilmCredits;
        httpRequest.open("GET", url, true);
        httpRequest.send();
    }
}

function gestisciFilmCredits(e)
{
    if (e.target.readyState == 4 && e.target.status == 200)
    {  

        var data = JSON.parse(e.target.responseText);

        var cast = data.cast;
        var str = "";
        for (var i=0; i<Math.min(4, cast.length); i++)
        {
            var actor = cast[i];
            str += actor["name"] + ", ";
        }
        str = str.slice(0, -2);
        document.getElementById("inputActors").value = str;

        var crew = data.crew;
        for (var i=0;i < crew.length; i++)
        {
            if (crew[i]["job"] == "Director")
                document.getElementById("inputRegia").value = crew[i]["name"];
        }
    }
}

function submitClick()
{
    document.getElementById("submitButton").value = "clicked";
}