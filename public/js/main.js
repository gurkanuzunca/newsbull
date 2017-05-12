

var baseUrl = document.getElementsByTagName('base')[0].href;
var language = document.getElementsByTagName('html')[0].getAttribute('lang');
var queryString = (function(a) {if (a === "") return {};var b = {};for (var i = 0; i < a.length; ++i){var p=a[i].split('=');if (p.length !== 2) continue;b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));}return b;})(window.location.search.substr(1).split('&'));



$(function() {
    $('#showcase .slick').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1
            }
        }]
    });

    $('.share-box').on('click', function(){
        window.open($(this).attr('href'), 'sharewindow', 'width=600,height=400');
        return false;
    });
});
