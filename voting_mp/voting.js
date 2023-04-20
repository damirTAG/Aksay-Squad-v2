// Ajax Voting Script - http://coursesweb.net
var ivotings = []; // store the items with voting
var ar_elm = []; // store the items that will be send to votAjax()
var i_elm = 0; // Index for elements aded in ar_elm
var itemvotin = ""; // store the voting of voted item
var voting_mp = "http://localhost/aksaysquad-project/voting_mp/"; // directory with files for script
var advote = 0; // variable checked in addVote(), if is 0 cann vote, else, not

// gets all DIVs, store in $ivotings, and in $ar_elm DIVs with class: "vot_plus", "vot_mp", and data-vote_id="..", sends to votAjax()
var getVotsElm = function () {
    var obj_div = document.querySelectorAll(".vot_mp1, .vot_mp2, .vot_plus");
    for (var i = 0; i < obj_div.length; i++) {
        var elm_id = obj_div[i].getAttribute("data-vote_id");
        if (elm_id) {
            ivotings[elm_id] = obj_div[i]; // store object item in $ivotings
            ar_elm[i_elm] = elm_id; // add item_ID in $ar_elm array, to be send in json string tp php
            i_elm++; // index order in $ar_elm
        }
    }
    // if there are elements in "ar_elm", send them to votAjax()
    if (ar_elm.length > 0) votAjax(ar_elm, ""); // if items in $ar_elm pass them to votAjax()
};

// add the ratting data to element in page
function addVotData(elm_id, v_plus, v_minus, voted) {
    var vote = v_plus - v_minus; // vote resulted
    var nvotes = v_plus + v_minus; //total nr. votes
    // exists elm_id stored in ivotings
    if (ivotings[elm_id]) {
        // sets to add "onclick" for vote down (minus) / up (plus), if voted is 0
        var clik_down = voted == 0 ? ' onclick="addVote(this, -1)"' : " onclick=\"alert('Вы уже проголосовали')\"";
        var clik_up = voted == 0 ? ' onclick="addVote(this, 1)"' : " onclick=\"alert('Вы уже проголосовали')\"";

        // if vot_plus, add code with <img> 'votplus', else, if vot_mp1/2, add code with <img> 'votup',  'votdown'
        if (ivotings[elm_id].className == "vot_plus") {
            // simple vote
            ivotings[elm_id].innerHTML = "<h4>" + vote + '</h4><div class="vot_plus"' + clik_up + "> &nbsp;</div>";
        } else if (ivotings[elm_id].className == "vot_mp1") {
            // up/down with total Votes
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
            // up/down with number of votes up and down
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

// Sends data to votAjax(), that will be send to PHP to register the vote
function addVote(ivot, vote) {
    // if $advote is 0, can vote, else, alert message
    if (advote == 0) {
        var elm = [];
        elm[0] = ivot.parentNode.getAttribute("data-vote_id"); // gets the item-id that will be voted

        ivot.parentNode.innerHTML = '<span class="sbi">Thanks</span>';
        votAjax(elm, vote);
    } else alert("Вы уже проголосовали");
}

/*** Ajax ***/
// sends data to PHP and receives the response
function votAjax(elm, vote) {
    var reqob = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"); // get XMLHttpRequest object

    // define data to be send via POST to PHP (Array with name=value pairs)
    var datasend = [];
    for (var i = 0; i < elm.length; i++) datasend[i] = "elm[]=" + elm[i];
    // joins the array items into a string, separated by '&'
    datasend = datasend.join("&") + "&vote=" + vote;

    reqob.open("POST", voting_mp + "voting.php", true); // crate the request

    reqob.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // header for POST
    reqob.send(datasend); //  make the ajax request, poassing the data

    // checks and receives the response
    reqob.onreadystatechange = function () {
        if (reqob.readyState == 4) {
            /// alert(reqob.responseText);  //for Debug
            // receives a JSON with one or more item:[vote, nvotes, voted]
            var vot_data = JSON.parse(reqob.responseText);

            // if vot_data is defined variable
            if (vot_data) {
                // parse the vot_data object
                for (var elm_id in vot_data) {
                    var voted = vot_data[elm_id].voted; // determine if the user can vote or not

                    // if voted=3 displays alert that already voted, else, continue with the voting reactualization
                    if (voted == 3) {
                        alert("Вы уже проголосовали \n Повторите попытку завтра");
                        window.location.reload(true); // Reload the page
                    } else addVotData(elm_id, vot_data[elm_id].v_plus, vot_data[elm_id].v_minus, voted); // calls function that shows voting
                }
            }

            // if voted is undefined or 2 (set to 1 NRVOT in voting.php), after vote, set $advote to 1
            if (vote != "" && (voted == undefined || voted == 2)) advote = 1;
        }
    };
}

window.addEventListener("load", getVotsElm); // calls getVotsElm() after page loads
