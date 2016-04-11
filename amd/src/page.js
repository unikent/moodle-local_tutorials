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
define(['jquery', 'core/ajax'], function($, ajax) {
    var tutorialids = [];
    var tutorialsteps = [];

    var initTutorials = function(data) {
        // Build steps
        $.each(data, function(i,o) {
            if (o.element.length > 0) {
                var elem = document.querySelector(o.element);
                if (!elem) {
                    return;
                }
            } else {
                delete o.element;
            }

            tutorialsteps.push(o);
            tutorialids.push(o.id);
        });

        if (tutorialsteps.length <= 0) {
            $("#tutorial-play").hide();
        }
    };

    var playTutorials = function() {
        if (tutorialsteps.length <= 0) {
            return;
        }

        require(['local_tutorials/intro'], function(introJs) {
            var intro = introJs();

            intro.setOptions({
                steps: tutorialsteps,
                nextLabel: 'Next',
                prevLabel: 'Back',
                skipLabel: 'Close',
                doneLabel: 'Close'
            });

            intro.onchange(function() {
                // Mark this step as complete.
                var tutid = tutorialids[this._currentStep];
                ajax.call([{
                    methodname: 'local_tutorials_mark_seen',
                    args: {
                        id: tutid
                    }
                }]);
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

    return {
        init: function(url, tutorials) {
            initTutorials(tutorials);

            $("#tutorial-play button").on('click', function() {
                playTutorials();

                return false;
            });
        }
    };
});
