$(function() {
    $.getJSON(M.cfg.wwwroot + "/local/tutorials/ajax/tutorials.php", {
        'page': window.location.href
    }, function(data) {
        $.each(data, function(i,o) {
            $.each(o, function(k,v) {
                if (k == 'element') {
                    data[i][k] = document.querySelector(v);
                }
            });
        });

        var intro = introJs();
        intro.setOptions({
            steps: data
        });
        intro.start();
    });
});
