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
define([], function() {
    return {
        init: function() {
            require(['local_tutorials/intro'], function(introJs) {
                var intro = introJs();
                intro.setOptions({
                    steps: [
                        { 
                            intro: "Hello world!"
                        },
                        {
                            element: document.querySelector('#block-region-side-pre'),
                            intro: "This is a tooltip."
                        },
                        {
                            element: document.querySelectorAll('#step2')[0],
                            intro: "Ok, wasn't that fun?",
                            position: 'right'
                        },
                        {
                            element: '#step3',
                            intro: 'More features, more fun.',
                            position: 'left'
                        },
                        {
                            element: '#step4',
                            intro: "Another step.",
                            position: 'bottom'
                        },
                        {
                            element: '#step5',
                            intro: 'Get it, use it.'
                        }
                    ]
                });
                intro.start();
            });
        }
    };
});
