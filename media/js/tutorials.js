$(function() {
    $.getJSON(M.cfg.wwwroot + "/local/tutorials/ajax/tutorials.php", {
        'page': window.location.href
    }, function(data) {
        if (data.length <= 0) {
            return;
        }

        // Internal reference table.
        var int_steps = [];

        // Build steps
        var steps = []
        $.each(data, function(i,o) {
            var elem = document.querySelector(o['element']);
            if (elem) {
                o['element'] = elem;
                steps.push(o);
                int_steps.push(o['id'])
            } // else, it is orphaned.
        });

        if (steps.length <= 0) {
            return;
        }

        var intro = introJs();

        intro.setOptions({
            steps: steps
        });

        intro.onchange(function(targetElement) {
            // Mark this step as complete.
            var tut_id = int_steps[this._currentStep];
            $.ajax({
                type: "POST",
                url: M.cfg.wwwroot + "/local/tutorials/ajax/progress.php",
                data: {
                    id: tut_id
                }
            })
        });

        intro.onexit(function() {
            // Do nothing for now.
        });

        intro.oncomplete(function() {
            // Do nothing for now.
        });

        intro.start();
    });
});
