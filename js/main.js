const image = document.querySelector(".index_slider");
let i = 1;

const pathList = ["./image/slider1.jpg", "./image/slider2.jpg", "./image/slider3.jpg", "./image/slider4.jpg"];

setInterval(function () {
    image.style.backgroundImage = `url("${pathList[i]}")`;
    i = (i + 1) % pathList.length;
}, 4000);

$(function () {
    $(window).scroll(function () {
        $(".fadeIn").each(function () {
            var position = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > position - windowHeight + 200) {
                $(function () {
                    $(".fadeIn").each(function (i) {
                        $(this)
                            .delay(i * 200)
                            .queue(function () {
                                $(this).addClass("animated");
                            });
                    });
                });
            }
        });
    });
});
