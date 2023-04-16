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
            url: "search.php",
            data: {
                name: $("#search").val(),
            },
            success: function (data) {
                $("#output").html(data);
            },
        });
    });
});

// document.getElementById("year").innerHTML = new Date().getFullYear();
// new Date().getFullYear();

// $("img[data-enlargable]")
//     .addClass("img-enlargable")
//     .click(function () {
//         var src = $(this).attr("src");
//         $("<div>")
//             .css({
//                 background: "RGBA(0,0,0,.5) url(" + src + ") no-repeat center",
//                 backgroundSize: "contain",
//                 width: "100%",
//                 height: "100%",
//                 position: "fixed",
//                 zIndex: "10000",
//                 top: "0",
//                 left: "0",
//                 cursor: "zoom-out",
//             })
//             .click(function () {
//                 $(this).remove();
//             })
//             .appendTo("body");
//     });

// let mybutton = document.getElementById("myBtn");

// window.onscroll = function () {
//     scrollFunction();
// };

// function scrollFunction() {
//     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
//         mybutton.style.display = "block";
//     } else {
//         mybutton.style.display = "none";
//     }
// }

// function topFunction() {
//     document.body.scrollTop = 0;
//     document.documentElement.scrollTop = 0;
// }
