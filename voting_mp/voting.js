// Ajax Voting Script - http://coursesweb.net
var ivotings = []; 
var ar_elm = []; 
var i_elm = 0; 
var itemvotin = ""; 
var voting_mp = "http://localhost/aksaysquad-project/voting_mp/"; 
var advote = 0; 


var getVotsElm = function () {
    var obj_div = document.querySelectorAll(".vot_mp1, .vot_mp2, .vot_plus");
    for (var i = 0; i < obj_div.length; i++) {
        var elm_id = obj_div[i].getAttribute("data-vote_id");
        if (elm_id) {
            ivotings[elm_id] = obj_div[i]; 
            ar_elm[i_elm] = elm_id; 
            i_elm++; 
        }
    }
    
    if (ar_elm.length > 0) votAjax(ar_elm, "");
};


function addVotData(elm_id, v_plus, v_minus, voted) {
    var vote = v_plus - v_minus; 
    var nvotes = v_plus + v_minus; 
    
    if (ivotings[elm_id]) {
        
        var clik_down = voted == 0 ? ' onclick="addVote(this, -1)"' : " onclick=\"alert('Вы уже проголосовали')\"";
        var clik_up = voted == 0 ? ' onclick="addVote(this, 1)"' : " onclick=\"alert('Вы уже проголосовали')\"";

        
        if (ivotings[elm_id].className == "vot_plus") {
            
            ivotings[elm_id].innerHTML = "<h4>" + vote + '</h4><div class="vot_plus"' + clik_up + "> &nbsp;</div>";
        } else if (ivotings[elm_id].className == "vot_mp1") {
            
            ivotings[elm_id].innerHTML =
                '<div class="nvotes">Votes: <b>' +
                nvotes +
                "</b></div><h4>" +
                vote +
                '</h4><div class="v_plus"' +
                clik_up +
                '> &nbsp;</div><div class="v_minus"' +
                clik_down +
                "> &nbsp;</div>";
        } else if (ivotings[elm_id].className == "vot_mp2") {
            
            ivotings[elm_id].innerHTML =
                "<h4>" +
                vote +
                '</h4><div class="vot_pm v_plus"' +
                clik_up +
                ">" +
                v_plus +
                '</div><div class="v_minus"' +
                clik_down +
                ">" +
                v_minus +
                "</div>";
        }
    }
}


function addVote(ivot, vote) {
    
    if (advote == 0) {
        var elm = [];
        elm[0] = ivot.parentNode.getAttribute("data-vote_id"); 

        ivot.parentNode.innerHTML = '<span class="sbi">Thanks</span>';
        votAjax(elm, vote);
    } else alert("Вы уже проголосовали");
}

/*** Ajax ***/

function votAjax(elm, vote) {
    var reqob = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    
    var datasend = [];
    for (var i = 0; i < elm.length; i++) datasend[i] = "elm[]=" + elm[i];
    
    datasend = datasend.join("&") + "&vote=" + vote;

    reqob.open("POST", voting_mp + "voting.php", true); // crate the request

    reqob.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // header for POST
    reqob.send(datasend); //  make the ajax request, poassing the data

    
    reqob.onreadystatechange = function () {
        if (reqob.readyState == 4) {
            /// alert(reqob.responseText);  //for Debug
            // receives a JSON with one or more item:[vote, nvotes, voted]
            var vot_data = JSON.parse(reqob.responseText);

            
            if (vot_data) {
                
                for (var elm_id in vot_data) {
                    var voted = vot_data[elm_id].voted;

                    // if voted=3 displays alert that already voted, else, continue with the voting reactualization
                    if (voted == 3) {
                        alert("Вы уже проголосовали \n Повторите попытку завтра");
                        window.location.reload(true); // Reload the page
                    } else addVotData(elm_id, vot_data[elm_id].v_plus, vot_data[elm_id].v_minus, voted); 
                }
            }

            // if voted is undefined or 2 (set to 1 NRVOT in voting.php), after vote, set $advote to 1
            if (vote != "" && (voted == undefined || voted == 2)) advote = 1;
        }
    };
}

window.addEventListener("load", getVotsElm);
