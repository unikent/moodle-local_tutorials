// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/*
 * @package    local_tutorials
 * @copyright  2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 /**
  * @module local_tutorials/page
  */
define(['jquery', 'core/ajax', 'core/notification'], function($, ajax, notification) {
    var initTutorials = function(data) {
        // Build steps
        var int_steps = [];
        var steps = [];
        $.each(data, function(i,o) {
            if (o['element'].length > 0) {
                console.log(o);
                var elem = document.querySelector(o['element']);
                if (!elem) {
                    console.log("Orphaned tutorial step: " + o['id']);
                    // TODO: Mark as orphaned.
                    return;
                }
            } else {
                delete o['element'];
            }

            if (!o['seen']) {
                steps.push(o);
                int_steps.push(o['id'])
            }
        });

        if (steps.length <= 0) {
            return;
        }

        require(['local_tutorials/intro'], function(introJs) {
            var intro = introJs();

            intro.setOptions({
                steps: steps
            });

            intro.onchange(function(targetElement) {
                // Mark this step as complete.
                /*var tut_id = int_steps[this._currentStep];
                $.ajax({
                    type: "POST",
                    url: M.cfg.wwwroot + "/local/tutorials/ajax/progress.php",
                    data: {
                        id: tut_id
                    }
                })*/
            });

            intro.onexit(function() {
                // Do nothing for now.
            });

            intro.oncomplete(function() {
                // Do nothing for now.
            });

            intro.start();
        });
    };

    var loadTutorials = function(url) {
        // Call AJAX webservice to search.
        var promises = ajax.call([{
            methodname: 'local_tutorials_get_tutorials',
            args: {
                url: url
            }
        }]);

        promises[0].done(function(response) {
            if (response.length <= 0) {
                return;
            }

            initTutorials(response);
        });

        promises[0].fail(notification.exception);
    };

    return {
        init: function(url) {
            $("#tutorial-play button").on('click', function() {
                loadTutorials(url);

                return false;
            });
        }
    };
});
