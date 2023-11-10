$(function () {
    $("#subForm").ebcaptcha();
});

// captcha
(function ($) {
    jQuery.fn.ebcaptcha = function (options) {
        var element = this;
        var input = this.find("#ebcaptchainput");
        var label = this.find("#ebcaptchatext");
        $(element).find("button[type=submit]").attr("disabled", "disabled");

        var randomNr1 = 0;
        var randomNr2 = 0;
        var totalNr = 0;

        randomNr1 = Math.floor(Math.random() * 10);
        randomNr2 = Math.floor(Math.random() * 10);
        totalNr = randomNr1 + randomNr2;
        var texti = "Сколько будет: " + randomNr1 + " + " + randomNr2;
        $(label).text(texti);

        $(input).keyup(function () {
            var nr = $(this).val();
            if (nr == totalNr) {
                $(element).find("button[type=submit]").removeAttr("disabled");
            } else {
                $(element).find("button[type=submit]").attr("disabled", "disabled");
            }
        });

        $(document).keypress(function (e) {
            if (e.which == 13) {
                if (element.find("button[type=submit]").is(":disabled") == true) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    };
})(jQuery);

$(document).ready(function () {
    $("#search").keypress(function () {
        $.ajax({
            type: "POST",
            url: "../search.php",
            data: {
                name: $("#search").val(),
            },
            success: function (data) {
                $("#output").html(data);
            },
        });
    });
});

let mybutton = document.getElementById("topBtn");

window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
function slowScroll(id) {
    var offset = 0;
    $("html, body").animate(
        {
            scrollTop: $(id).offset().top - offset,
        },
        900
    );
    return false;
}

// audio play on each page
window.onload = function () {
    var audio = document.getElementById("audio-quotes");

    if (localStorage.getItem("audioTime")) {
        audio.currentTime = parseFloat(localStorage.getItem("audioTime"));
        audio.play();
    }

    window.onbeforeunload = function () {
        localStorage.setItem("audioTime", audio.currentTime);
    };
};
