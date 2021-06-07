/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import $ from 'jquery'
global.$ = global.jQuery = $;

import 'bootstrap';
import "@fortawesome/fontawesome-free/js/all.js";
import 'bootstrap-select';
import 'datatables.net';
import dt from 'datatables.net-bs4';
dt(window, $);

import 'chart.js';
import 'admin-lte';
// any CSS you import will output into a single css file (app.css in this case)
import './app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
