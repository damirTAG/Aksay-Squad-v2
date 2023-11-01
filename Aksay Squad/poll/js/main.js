$(function () {
    var pathToPolls = "polls.php";

    var vote = {};
    $.get(pathToPolls, function (data) {
        var data = JSON.parse(data);
        vote["id"] = data["id"];
        vote["question"] = data["question"];
        vote["answers"] = data["answers"];

        if (data.hasOwnProperty("result")) {
            $("#vote").parent().parent().find(".question").text(vote["question"]);
            var _answers = vote["answers"];
            var output = "";
            var result = data["result"];
            var totalvotes = 0;
            for (var i = 0; i <= result.length - 1; i++) {
                totalvotes += result[i];
            }
            for (var i = 0; i <= result.length - 1; i++) {
                output +=
                    '<p style="margin:0px;">' +
                    _answers[i] +
                    "</p>" +
                    '<p class="text-right" style="margin:0px;"><b>' +
                    ((result[i] / totalvotes) * 100).toFixed(1) +
                    "%</b> (Голосов: " +
                    result[i] +
                    ")</p>" +
                    '<div class="progress">' +
                    '<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="' +
                    (result[i] / totalvotes) * 100 +
                    '" aria-valuemin="0" aria-valuemax="100" style="width: ' +
                    (result[i] / totalvotes) * 100 +
                    '%">' +
                    '<span class="sr-only">' +
                    (result[i] / totalvotes) * 100 +
                    "%</span>" +
                    "</div>" +
                    "</div>";
            }
            $("#vote-section").html(output);
        } else {
            processPoll();
        }
    });

    var processPoll = function () {
        var _id = vote["id"];
        var _answers = vote["answers"];
        var form = $("#vote");
        form.parent().parent().find(".question").text(vote["question"]);
        form.prepend('<input type="hidden" name="count" value="' + vote["answers"].length + '">');
        form.prepend('<input type="hidden" name="id" value="' + vote["id"] + '">');
        var answers = form.find(".answers");
        for (var i = 0; i <= vote["answers"].length - 1; i++) {
            answers.append(
                '<div class="radio">' +
                    "<label>" +
                    '<input type="radio" name="poll" value="' +
                    (i + 1) +
                    '">' +
                    vote["answers"][i] +
                    "</label>" +
                    "</div>"
            );
        }
        if (form.find('button[type="submit"]:disabled')) {
            form.find('input[type="radio"]').click(function () {
                form.find('button[type="submit"]').prop("disabled", false);
                form.find('input[type="radio"]').off("click");
            });
        }

        form.submit(function (e) {
            //отмена действия по умолчанию для кнопки submit
            e.preventDefault();
            $.post(form.attr("action"), form.serializeArray(), function (data) {
                if (data) {
                    var data = JSON.parse(data);
                    var output = "";
                    var result = data[_id];
                    var totalvotes = 0;
                    for (var i = 0; i <= result.length - 1; i++) {
                        totalvotes += result[i];
                    }
                    for (var i = 0; i <= result.length - 1; i++) {
                        output +=
                            '<p style="margin:0px;">' +
                            _answers[i] +
                            "</p>" +
                            '<p class="text-right" style="margin:0px;"><b>' +
                            ((result[i] / totalvotes) * 100).toFixed(1) +
                            "%</b> (Голосов: " +
                            result[i] +
                            ")</p>" +
                            '<div class="progress">' +
                            '<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="' +
                            (result[i] / totalvotes) * 100 +
                            '" aria-valuemin="0" aria-valuemax="100" style="width: ' +
                            (result[i] / totalvotes) * 100 +
                            '%">' +
                            '<span class="sr-only">' +
                            (result[i] / totalvotes) * 100 +
                            "%</span>" +
                            "</div>" +
                            "</div>";
                    }
                    $("#vote-section").html(output);
                }
            });
        });
    };
});

const comments_page_id = 1; // This number should be unique on every page
fetch("comments.php?page_id=" + comments_page_id)
    .then((response) => response.text())
    .then((data) => {
        document.querySelector(".comments").innerHTML = data;
        document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach((element) => {
            element.onclick = (event) => {
                event.preventDefault();
                document.querySelectorAll(".comments .write_comment").forEach((element) => (element.style.display = "none"));
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = "block";
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
            };
        });
        document.querySelectorAll(".comments .write_comment form").forEach((element) => {
            element.onsubmit = (event) => {
                event.preventDefault();
                fetch("comments.php?page_id=" + comments_page_id, {
                    method: "POST",
                    body: new FormData(element),
                })
                    .then((response) => response.text())
                    .then((data) => {
                        element.parentElement.innerHTML = data;
                    });
            };
        });
    });

window.addEventListener("scroll", function () {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});

new TypeIt("#idtitle", {
    speed: 100,
    waitUntilVisible: true,
})
    .type("опросами", { delay: 700 })

    .type(" и коментариями")
    .go();

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

//pagination
