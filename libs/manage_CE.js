











////////////////////////////////////////////////////////////////
// AFFICHAGE
////////////////////////////////////////////////////////////////

function afficherSessions(){
    let ulBalise = document.createElement("UL");
    ulBalise.setAttribute("id", "ul_sessions");

    getSessions().then((listes) => {
        listes.forEach(appendSession)
    })

    document.getElementById("div_sessions").appendChild(createFormSession());
    document.getElementById("div_sessions").appendChild(ulBalise);    
}

function afficherListes(){
    let ulBalise = document.createElement("UL");
    ulBalise.setAttribute("id", "ul_listes");

    getListes().then((listes) => {
        listes.forEach(appendListe)
    })

    document.getElementById("div_listes").appendChild(createFormListe());
    document.getElementById("div_listes").appendChild(ulBalise);
}

function afficherCandidatsCA(){
    let div = document.createElement("DIV");
    div.setAttribute("id", "matrix_candidats_CA");
    div.setAttribute("class", 'row')

    getCandidats().then((candidats) => {
        candidats.forEach(appendCandidatCA)
    })

    document.getElementById("div_candidats_CA").appendChild(createFormCandidatCA());
    document.getElementById("div_candidats_CA").appendChild(div);

}

function appendSession(session){
    document.getElementById("ul_sessions")
        .appendChild(createLiSession(session));
}

function appendListe(liste){
    document.getElementById("ul_listes")
        .appendChild(createLiListe(liste));
}

function appendCandidatCA(candidat){
    document.getElementById("matrix_candidats_CA")
        .appendChild(createPortraitCandidatCA(candidat));
}

function createLiSession(session){
    let li = document.createElement("LI");
    li.setAttribute("id_session", session.id);
    li.appendChild(createSpan(session.type));
    li.appendChild(createSpan(session.date));
    li.appendChild(createSpan(session.heure_debut));
    li.appendChild(createSpan(session.heure_fin));
    li.appendChild(createBttnDelSession());
    
    return li;
}

function createLiListe(liste){
    let li = document.createElement("LI");
    li.setAttribute("id_liste", liste.id);
    li.innerHTML = liste.nom_liste;
    li.appendChild(createBttnDelListe());
    
    return li;
}

function createPortraitCandidatCA(candidat){
    let div = document.createElement("DIV");
    div.setAttribute("class", "cb_unselected");
    div.setAttribute("id_candidat", candidat.id);

    let img = document.createElement("IMG");
    img.setAttribute("src", "images/cand_" + candidat.id);    

    div.appendChild(img);
    div.appendChild(createDiv(candidat.nom + " - " + candidat.college));

    let div2 = document.createElement("DIV");
    div2.appendChild(createBttnDelCandidatCA());
    div.appendChild(div2);
    return div;
}

function createBttnDelCandidatCA(){
    let bttnDel = document.createElement("BUTTON");
    bttnDel.innerHTML = "Supprimer";
    bttnDel.onclick = function() {
        let id = this.parentElement.parentElement.getAttribute("id_candidat");
        delCandidatCA({id: id});
        this.parentElement.parentElement.parentElement.removeChild(this.parentElement.parentElement);
    };
    return bttnDel;
}

function createBttnDelListe(){
    let bttnDel = document.createElement("BUTTON");
    bttnDel.innerHTML = "Supprimer";
    bttnDel.onclick = function() {
        let liste = {id: this.parentElement.getAttribute("id_liste")}
        delListe(liste);
        this.parentElement.parentElement.removeChild(this.parentElement);
    };
    return bttnDel;
}

function createBttnDelSession(){
    let bttnDel = document.createElement("BUTTON");
    bttnDel.innerHTML = "Supprimer";
    bttnDel.onclick = function() {
        let session = {id: this.parentElement.getAttribute("id_session")}
        delSession(session);
        this.parentElement.parentElement.removeChild(this.parentElement);
    };
    return bttnDel;
}

function createDiv(text){
    let div = document.createElement("DIV");
    div.innerHTML = text;
    return div;
}

function createSpan(text){
    let span = document.createElement("SPAN");
    span.innerHTML = text;
    return span;
}

function createTextInput(defText, name){
    let input = document.createElement("INPUT");
    input.setAttribute("type", "text");
    input.setAttribute("name", name);
    input.setAttribute("value", defText);
    input.onclick = function(){this.setAttribute("value", "")};

    return input;
}

function createDateInput(defDate, name){
    let input = document.createElement("INPUT");
    input.setAttribute("type", "date");
    input.setAttribute("name", name);
    input.setAttribute("value", defDate);
    input.onclick = function(){this.setAttribute("value", "")};

    return input;
}

function createHeureInput(defHeure, name){
    let input = document.createElement("INPUT");
    input.setAttribute("type", "time");
    input.setAttribute("name", name);
    input.setAttribute("value", defHeure);
    input.onclick = function(){this.setAttribute("value", "")};

    return input;
}

function inputFileSelected(input){
    const file = input.target.files[0];
    const reader = new FileReader();
  
    // We read the file and call the upload function with the result
    reader.onload = (res) => {
        this.setAttribute("res", res.currentTarget.result);
    };
    reader.readAsDataURL(file);
}

function createInputFile(name, accept){
    let input = document.createElement("INPUT");
    input.setAttribute("type", "file");
    input.setAttribute("name", name);
    input.setAttribute("id", name);
    input.setAttribute("accept", accept);
    input.addEventListener('change', inputFileSelected, false);

    return input;
}

function createLabel(value, id){
    let label= document.createElement("LABEL");
    label.setAttribute("for", id);
    label.innerHTML = value;

    return label;
}

function createFormSession(){
    let div = document.createElement("DIV");
    let bttn = document.createElement("BUTTON");
    bttn.innerHTML = "Ajouter une session";
    bttn.onclick = function(){
        let newType = this.parentElement.children[0].value;
        let newDate = this.parentElement.children[1].value;
        let newDebut = this.parentElement.children[2].value;
        let newFin = this.parentElement.children[3].value;
        
        let session = {type: newType, date: newDate, hDebut: newDebut, hFin: newFin};
        addSession(session);
    }

    div.appendChild(createTextInput("Type de session [ca, event, bdx]", "add_session_type"));
    div.appendChild(createTextInput("1901-01-01", "add_session_date"));
    div.appendChild(createTextInput("00:00:00", "add_session_debut"));
    div.appendChild(createTextInput("23:59:00", "add_session_fin"));
    div.appendChild(bttn);
    
    return div;
}

function createFormListe(){
    let div = document.createElement("DIV");
    let bttn = document.createElement("BUTTON");
    bttn.innerHTML = "Ajouter une liste";
    bttn.onclick = function(){
        let new_name = this.parentElement.firstChild.value;
        let liste = {nom: new_name};
        addListe(liste);
    }

    div.appendChild(createTextInput("Nouvelle liste", "add_liste"));
    div.appendChild(bttn);
    
    return div;
}

function createFormCandidatCA(){
    let div = document.createElement("DIV");
    div.setAttribute("class", "row");
    let inputImg = createInputFile("add_cand_img", "image/*", "Ajouter photo");
    let inputMotiv = createInputFile("add_cand_motiv", ".txt", "Ajouter motivation");
    
    let bttn = document.createElement("BUTTON");
    bttn.innerHTML = "Ajouter un candidat";
    bttn.onclick = function(){
        let new_name = this.parentElement.children[0].value;
        let new_coll = this.parentElement.children[1].value;
        let new_img = this.parentElement.children[2].getAttribute("res");
        let new_motiv = this.parentElement.children[3].getAttribute("res");        

        let candidat = {nom: new_name, college: new_coll, pic: new_img, motiv: new_motiv};
        addCandidatCA(candidat);
    }

    div.appendChild(createTextInput("Nom prénom", "add_cand_name"));
    div.appendChild(createTextInput("College (G1, G2, G3, IE2, IE34, IE5", "add_cand_college"));
    div.appendChild(createLabel("Ajouter photo : ", "add_cand_img"));
    div.appendChild(inputImg);
    div.appendChild(createLabel("Ajouter motivation : ", "add_cand_motiv"));
    div.appendChild(inputMotiv);
    div.appendChild(bttn);
    
    return div;
}

////////////////////////////////////////////////////////////////
// DATA.PHP REQUESTS
////////////////////////////////////////////////////////////////

function queryStringify(data){
    return Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&');
}

function rightFetch(url, params){
    return fetch(url,
        {
            method: params.method,
            body: queryStringify(params.body),
            headers:{'content-type': 'application/x-www-form-urlencoded'},
            credentials: 'include'
        }
    )
    .then((r) => {
        console.log(r);
        if (!r.ok) throw Error(r.statusText);
        return r.json();
    });
}

function getSessions(){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "getSessions"
        }
    })
    .then((json_r) => {
        console.log(json_r);
        return json_r.sessions;
    });
}

function getListes(){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "getListes"
        }
    })
    .then((json_r) => {
        return json_r.listes;
    });
}

function getCandidats(){
    
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "getCandidatsCA"
        }
    })
    .then((json_r) => {
        return json_r.candidats;
    });
}

function addSession(session){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "addSession",
            type: session.type,
            date: session.date,
            h_debut: session.hDebut,
            h_fin: session.hFin
        }
    })
    .then((json_r) => {
        return json_r.id;
    });
}

function addListe(liste){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "addListe",
            nom: liste.nom
        }
    })
    .then((json_r) => {
        return json_r.id;
    });
}

function addCandidatCA(candidat){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "addCandidatCA",
            college: candidat.college,
            nom: candidat.nom,
            pic: candidat.pic,
            motiv: candidat.motiv
        }
    })
    .then((json_r) => {
        console.log(json_r);        
        return json_r.id;
    });
}

function delSession(session){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "delSession",
            id: session.id
        }
    })
    .then((r) => {
        return r;
    });
}

function delListe(liste){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "delListe",
            id: liste.id
        }
    })
    .then((r) => {
        return r;
    });
}

function delCandidatCA(candidat){
    return rightFetch('data.php', {
        method: "POST",
        body: {
            action: "delCandidatCA",
            id: candidat.id
        }
    })
    .then((r) => {
        return r;
    });
}
