new TypeIt("#idtitle", {
    speed: 100,
    waitUntilVisible: true,
})
    .type("базу воспоминаний", { delay: 700 })
    .delete(17)
    .type("моменты")
    .pause(700)
    .delete(9)
    .type("в гору ностальгий")
    .pause(700)
    .go();

window.addEventListener("scroll", function () {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});

let products = {
    data: [
        // 2019
        {
            category: "2019",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Dxy7p1YUR3zqccX_lDP2_-iAqeUjaa1G",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1XhKczNrabI-h5Uxe48-TyBN8mXrz4qxT",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1q9gqD06JBM_1AOnn6cbGGY5n6btuiUww",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1OPgsDkFftZCKBgAhnVyRgfJdkGpRjNC7",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1q_1Dm9GXtfCbUwuxejaHnJZ_oSY-balS",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1WDZXWO-8kcXqMpgp7mxg-gnQxZuhe0LX",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1kXAbwuOGQTmJ3_h2mV6YbNXjjSe5bOUB",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=18IHXjCR1ECqoU-yPPt2TULdOOdb9i455",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1o7FcHjXb62UwnSC77Ze_qvEFXwC95QaY",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1vZVGsHkPtEV1EAc09Ltpl3TbxSvYKI0h",
        },
        {
            category: "2019",
            width: "data-enlargable",
            image: "https://drive.google.com/uc?export=view&id=1wzXCFFp0lt1g6yMkIpdjb-34_OZxRfOx",
        },
        // 2020
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1myMhoGdlUHCE-hoX3nln82d7GJ84teYt",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1IsIRcvHmDVPDMWWSGKNrZA9W2vi-5NN2",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1SjwfNUZ5NUO2RW4gXKXsAEDsBHZDHbeT",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1p_Fo81uJ_oA5FcJ2uCbtTsbTu6o-cG7Z",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1XSnuKZqB3X0KPAkwpD7r_66qR03hHv19",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Pjo_XFPcuOaZTvGQYw2EaK_cRdo9kCX8",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Yi7-YtQdGxzssPAKhO0cxRIxVEBvoGdC",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=14fmLz6R9v_5njVEjB5DBiX5Z-h743SXL",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1xT1M6-sy4fqs2kBL9oBWnJhRGH864Vx0",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1FTWfeOC3BsEUKpNwZ0nLEqj1QXsqnu5M",
        },
        {
            category: "2020",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1QIYNuxFfSIQy5WHxDQqRsgKVc3eNgxSh",
        },
        // 2021
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Wm4Y_Vv3t7pare4WfZQaKOqaD72vs9jZ",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1RWfHJEErCbpj20PlDVrm5XXxheAoImFE",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1YtN_pe52bvcRSwy_OoXb-TeXRykv7nbp",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1sI_xBg0DdVVh1E20M7gnWYK6aiwxsMuP",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=11vVePn77HwFlfJx_vZq9qlAhzOa-3ojN",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1MqZ01-f_ibJ6Jh522xfEP2mWF6Wj8u0O",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1DTkhrCJLUdJfG1KrEjk93XwC8CHpKePB",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1EYDn7P7XULea1RuPS2xbZrIfO9pw8dA7",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=143Dv-BZfX-j4aH7oaIXAzP4mcBgOWv8Z",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1M5JtjvMMA6qQ8z27eRLEWPMbx1g_6BUh",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1zvotG0TTPQy1B1WbiiDwQMxt9vvEPJ3x",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1VGVmtC3Qvy2io2n5neXyIeUtpYc_LvcF",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1wn4vdjvqYrzkDQrxNrdi5NHCtAbmBWdW",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1E11ecAlCZxiKUscf7tHUcUS_h2rbA397",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Vlu0mFPJlolntJvE7GbFwXrgCfJP3D7n",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1cvpdXNRU-Haj7sj6EVZNL2cbJKTn7Ege",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Ldw3K1AkynWH2zW4MTPFsKbI7uhu7qbz",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=18Gdb4ZIzRJDvbyQgBG7WYmlV3l-z_0UE",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1oo0wTNLZjbbqi3lzBb7ebR6QhKpc5eeF",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1ddwWUKTopuQvl-CSEeRHFn3hwKyLJuSi",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1MzcTrr4M_nXGw7kFQPBIku1KTcIO6aNT",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1ZE1GA-v-WWH-Pqr4DsUs3ITWENr2_hTP",
        },
        {
            category: "2021",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Kp_drLgsr0KH4FNcN3xAHx3p8CCQmliA",
        },
        // 2022
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1mtjFJPIYnZlGmni9hvlemwBZMawXwLBZ",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1K24kDpKkt47IhwE9YRLZIncLK4R81_8k",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1mSnSZj5CNwkQkAwFzRfbNjUAOPmHnPAr",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Y9mw6U-X2N81LnaiXJ3Thukae-fYKHE7",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1_cDpW5ivAIKs23dyIdad0ahaP2LRq4QS",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1iAIbZ7MYKFJuhK4PtdCyvfJ-b4-Ra7Pr",
        },
        {
            category: "2022",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=102LGkr5iX4MMjf3HeFbGZ4l21HZZdC2t",
        },

        // 2023
        {
            category: "2023",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1JijTbklTMAoHFTgZLAD0sSNOp9Yo41DO",
        },
        {
            category: "2023",
            width: "data-enlargable",
            image: "http://drive.google.com/uc?export=view&id=1Avw6NYuqGGNeEFk6ZGIls9yuuv_ZRV4I",
        },
    ],
};

function FullView(ImgLink) {
    document.getElementById("FullImage").src = ImgLink;
    document.getElementById("FullImageView").style.display = "block";
}
function CloseFullView() {
    document.getElementById("FullImageView").style.display = "none";
}

for (let i of products.data) {
    //Create Card
    let card = document.createElement("div");
    //Card should have category and should stay hidden initially
    card.classList.add("card", i.category, "hide");

    //image div
    let imgContainer = document.createElement("div");
    imgContainer.classList.add("image-container");

    //img tag
    let image = document.createElement("img");
    image.setAttribute("onclick", "FullView(this.src)");
    image.setAttribute("src", i.image);
    imgContainer.appendChild(image);
    card.appendChild(imgContainer);
    //container
    let container = document.createElement("div");
    container.classList.add("container");

    card.appendChild(container);
    document.getElementById("products").appendChild(card);
}

//parameter passed from button (Parameter same as category)
function filterProduct(value) {
    //Button class code
    let buttons = document.querySelectorAll(".button-value");
    buttons.forEach((button) => {
        //check if value equals innerText
        if (value.toUpperCase() == button.innerText.toUpperCase()) {
            button.classList.add("active");
        } else {
            button.classList.remove("active");
        }
    });

    //select all cards
    let elements = document.querySelectorAll(".card");
    //loop through all cards
    elements.forEach((element) => {
        //display all cards on 'all' button click
        if (value == "all") {
            element.classList.remove("hide");
        } else {
            //Check if element contains category class
            if (element.classList.contains(value)) {
                //display element based on category
                element.classList.remove("hide");
            } else {
                //hide other elements
                element.classList.add("hide");
            }
        }
    });
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
