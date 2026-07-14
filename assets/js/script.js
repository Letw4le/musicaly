const menu = document.getElementById("menu");
const menu_txt_home = document.getElementById("txt_home");
const menu_txt_research = document.getElementById("txt_research");
const menu_txt_historic = document.getElementById("txt_historic");
const menu_txt_login = document.getElementById("txt_login");
const input_research = document.getElementById("search_input");
const results = document.getElementById("results");
const artist_presentation_infos = document.getElementById("artist_presentation_infos");
const artist_name = document.getElementById("artist_name");
const artist_spotify_button = document.getElementById("artist_spotify_button");
const artist_spotify_img = document.getElementById("artist_img");
const artist_albums = document.getElementById("artist_albums");
const album_img = document.getElementById("album_img");
const album_name = document.getElementById("album_name");


let recherche;
let tab_comparaison, tab_artists, tab_albums, tab_tracks;

function DisplayHeader(name){
    if(name == "home"){
        menu_txt_home.setAttribute("class", "actual_onglet");
        menu_txt_research.classList.remove('actual_onglet'); 
        menu_txt_historic.classList.remove('actual_onglet'); 
        menu_txt_login.classList.remove('actual_onglet'); 
        
    }else if(name == "research"){
        menu_txt_research.setAttribute("class", "actual_onglet");
        menu_txt_home.classList.remove('actual_onglet'); 
        menu_txt_historic.classList.remove('actual_onglet'); 
        menu_txt_login.classList.remove('actual_onglet'); 
    }else if(name == "historic"){
        menu_txt_historic.setAttribute("class", "actual_onglet");
        menu_txt_research.classList.remove('actual_onglet'); 
        menu_txt_home.classList.remove('actual_onglet'); 
        menu_txt_login.classList.remove('actual_onglet'); 
    }else{
        menu_txt_login.setAttribute("class", "actual_onglet");
        menu_txt_research.classList.remove('actual_onglet'); 
        menu_txt_historic.classList.remove('actual_onglet'); 
        menu_txt_home.classList.remove('actual_onglet'); 
    }

    if(userConnected) {
        // remplace "Se connecter" par le pseudo
        menu_txt_login.innerText = userConnected;
        menu_txt_login.setAttribute("href", "index.php?page=profile");
    }
}


//Partie  Recherche musique, artiste, album
if(input_research) {
    input_research.addEventListener('input', function(e) {
        requete =  input_research.value;
        results.innerHTML = '';
        if(requete != ""){
            rechercher(requete);
        }
        
    });
}

async function rechercher(query){
    const response = await fetch('index.php?page=research&research=' + query);
    const data = await response.json();


    data_recherches = comparaisonRecherche(data, query);

    results.innerHTML = '';

    data_recherches.forEach(item => {
        const display_result = document.createElement("div");
        display_result.setAttribute("class","one_result");
        results.appendChild(display_result);

        // vérification que l'image existe
        if(item.images && item.images.length > 0) {
            const result_img = document.createElement("img");
            const smallImg = item.images[item.images.length - 1]; // prend l'image la plus petite disponible
            result_img.setAttribute("src", smallImg.url);
            result_img.setAttribute("alt", "");
            result_img.setAttribute("width", "40");
            result_img.setAttribute("height", "40");
            display_result.appendChild(result_img);
        }

        const result_name = document.createElement("div");
        result_name.innerText = item.name;
        result_name.setAttribute("class","result_name");
        display_result.appendChild(result_name);

        const result_point = document.createElement("div");
        result_point.setAttribute("class","point")
        display_result.appendChild(result_point);

        const result_type = document.createElement("div");
        result_type.setAttribute("class","result_type");
        result_type.innerText = item.type;
        display_result.appendChild(result_type);

        const result_header = document.createElement("a");
        result_header.setAttribute("class","result_header");
        result_header.setAttribute("href","index.php?page=result&research_type=" + item.type + "&id=" + item.id);
        display_result.appendChild(result_header);


    });
}


function comparaisonRecherche(data, recherche) {
    const artists = (data.artists || []).map(a => ({ ...a, type: 'artist' }));
    const albums  = (data.albums  || []).map(a => ({ ...a, type: 'album' }));
    const tracks  = (data.tracks  || []).map(t => ({ ...t, type: 'track' }));

    const tousLesResultats = [...artists, ...albums, ...tracks];
    

    tousLesResultats.sort((a, b) => score(b.name, recherche) - score(a.name, recherche));
    return tousLesResultats.slice(0, 10);
}

function score(nom, recherche) {
    nom = nom.toLowerCase();
    recherche = recherche.toLowerCase();
    if(nom === recherche) return 3;         // correspondance exacte
    if(nom.startsWith(recherche)) return 2; // commence par la recherche
    if(nom.includes(recherche)) return 1;   // contient la recherche
    return 0;
}

async function getArtistData(id){
    const response = await fetch('index.php?page=getInfos&research_type=artist&id=' + id);
    const data = await response.json();

    artist_name.innerText = data.name;
    artist_spotify_button.setAttribute("href",data.external_urls.spotify);
    if(data.images.length > 0){
        artist_spotify_img.setAttribute("crossorigin", "anonymous");
        artist_spotify_img.setAttribute("src", data.images[0].url);
        
        artist_spotify_img.addEventListener('load', function() {
            const colorThief = new ColorThief();
            const color = colorThief.getColor(artist_spotify_img); // retourne [r, g, b]
            
            // applique la couleur dominante en fond
            document.getElementById('artist_presentation').style.background = 
                `linear-gradient(to right, rgb(${color[0]}, ${color[1]}, ${color[2]}), #0b0a08)`;
        });
    }
    
}

async function getArtistAlbumData(id){
    const response = await fetch('index.php?page=getInfos&research_type=artist_albums&id=' + id);
    const data = await response.json();

    console.log(data);
    

    data.items.forEach(item => {
        const one_album = document.createElement("a");
        one_album.setAttribute("class", "one_album");
        one_album.setAttribute("href", "index.php?page=result&research_type=album&id=" + item.id);
        artist_albums.appendChild(one_album);

        // vérification que l'image existe
        if(item.images && item.images.length > 0) {
            const album_img = document.createElement("img");
            const smallImg = item.images[0]; 
            album_img.setAttribute("src", smallImg.url);
            album_img.setAttribute("alt", "");
            one_album.appendChild(album_img);
        }

        const album_name = document.createElement("span");
        album_name.innerText = item.name;
        one_album.appendChild(album_name);


    });
}

async function getAlbumData(id){
    const response = await fetch('index.php?page=getInfos&research_type=album&id=' + id);
    const data = await response.json();

    //nom
    album_name.innerText = data.name;

    //url bouton
    artist_spotify_button.setAttribute("href",data.external_urls.spotify);

    // genres
    const album_genres = document.getElementById('album_genres');
    if(data.genres && data.genres.length > 0) {
        album_genres.innerText = data.genres.join(' - ');
    }

    // année
    const album_date = document.getElementById('album_date');
    if(data.release_date) {
        album_date.innerText = data.release_date.slice(0, 4);
    }

    if(data.images.length > 0){
        album_img.setAttribute("crossorigin", "anonymous");
        album_img.setAttribute("src", data.images[0].url);
        
        album_img.addEventListener('load', function() {
            const colorThief = new ColorThief();
            const color = colorThief.getColor(album_img); // retourne [r, g, b]
            const r = color[0], g = color[1], b = color[2];
            
            // applique la couleur dominante en fond
            document.getElementById('background').style.background = `
                radial-gradient(60% 60% at 90% -10%, rgba(${r}, ${g}, ${b}, 0.12) 0%, transparent 90%),
                radial-gradient(50% 50% at -10% 70%, rgba(${r}, ${g}, ${b}, 0.12) 0%, transparent 90%),
                #0b0a08`;
        });
    }

    // tracks
    const album_tracks = document.getElementById('album_tracks');
    album_tracks.innerHTML = '';

    if(data.tracks && data.tracks.items.length > 0){
        data.tracks.items.forEach((track, index) => {
            const one_track = document.createElement("a");
            one_track.setAttribute("class", "one_track");
            one_track.setAttribute("href", "index.php?page=result&research_type=track&id=" + track.id);
            album_tracks.appendChild(one_track);

            // numéro
            const track_index = document.createElement("span");
            track_index.setAttribute("class", "track_index");
            track_index.innerText = index + 1;
            one_track.appendChild(track_index);

            // titre
            const track_title = document.createElement("span");
            track_title.setAttribute("class", "track_title");
            track_title.innerText = track.name;
            one_track.appendChild(track_title);

            // durée
            const track_duration = document.createElement("span");
            track_duration.setAttribute("class", "track_duration");
            const minutes = Math.floor(track.duration_ms / 60000);
            const secondes = Math.floor((track.duration_ms % 60000) / 1000);
            track_duration.innerText = `${minutes}:${secondes.toString().padStart(2, '0')}`;
            one_track.appendChild(track_duration);
        });
    }
    
}

async function getTrackData(id) {
    const response = await fetch('index.php?page=getInfos&research_type=track&id=' + id);
    const data = await response.json();

    console.log(data);

    // nom
    document.getElementById('track_name').innerText = data.name;

    // durée
    const minutes = Math.floor(data.duration_ms / 60000);
    const secondes = Math.floor((data.duration_ms % 60000) / 1000);
    document.getElementById('track_duration').innerText = `${minutes}:${secondes.toString().padStart(2, '0')}`;

    // année
    if(data.album && data.album.release_date) {
        document.getElementById('track_date').innerText = data.album.release_date.slice(0, 4);
    }

    // bouton spotify
    artist_spotify_button.setAttribute('href', data.external_urls.spotify);

    // image de l'album
    if(data.album && data.album.images && data.album.images.length > 0) {
        const track_img = document.getElementById('track_img');
        track_img.setAttribute('crossorigin', 'anonymous');
        track_img.setAttribute('src', data.album.images[0].url);

        track_img.addEventListener('load', function() {
            const colorThief = new ColorThief();
            const color = colorThief.getColor(track_img);
            const r = color[0], g = color[1], b = color[2];

            document.getElementById('background').style.background = `
                radial-gradient(60% 60% at 90% -10%, rgba(${r}, ${g}, ${b}, 0.12) 0%, transparent 90%),
                radial-gradient(50% 50% at -10% 70%, rgba(${r}, ${g}, ${b}, 0.12) 0%, transparent 90%),
                #0b0a08`;
        });
    }
}

async function loadReviewTrackNames(){
    const reviews = document.querySelectorAll('.one_review');
    
    reviews.forEach(async review => {
        const id = review.dataset.spotifyId;
        const type = review.dataset.type;
        
        const response = await fetch(`index.php?page=getInfos&research_type=${type}&id=${id}`);
        const data = await response.json();
        
        review.querySelector('.review_track_name').innerText = data.name;
    });
}
