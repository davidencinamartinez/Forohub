const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/327Yoc5QodjbmDMrPGvyS4bb5OWaxwuVzqQGR8DEpwybWUOAQj9c1ZMnOqwmykTm.scss', 'public/css'); // min.css
mix.sass('resources/sass/3SNhbCgEn43DJcWvdwn1GRdusN2TSe5OnKujM0fAnOjwofJyLf1DZqRKbpf49Qxw.scss', 'public/css'); // header.css
mix.sass('resources/sass/7gRTS9REZpLyk7xC8v8z0RFI58bZ0LhMhhEA0m3X8IgNrMDYcRPTO2a64ZN1hCoN.scss', 'public/css'); // footer.css
mix.sass('resources/sass/8AE3kMi5LgMMKoboN0dEZF8aHTmAeZ1xmReLDBB2cJd4ytvHNPlzfT0m3SI5lH40.scss', 'public/css'); // classes.css
mix.sass('resources/sass/Ac7PvcuJsoVpdzpSoOMzfwJeoCGY8lDJaPjgd7JtVCHPldfs3jy12sw7wcxRZYiF.scss', 'public/css'); // modal.css
mix.sass('resources/sass/B7o87L2YkZdnuQkqz68BKA35j2mc0OLjT86jSOrps19DHKjTHCVjMrjaQCpz7m6k.scss', 'public/css'); // thread_panel.css
mix.sass('resources/sass/dYLviCaMKKoganQbQUa7lwhnlGund6PVLESCtn4jSJ00xXWCahDLUxHsMjyDFpHu.scss', 'public/css'); // misc_panel.css
mix.sass('resources/sass/L02AaerYckTaqAgneODgPhYXNglw7NjScj7Wvu2SulxxotSZiCMHJpQ7fQKdIfU0.scss', 'public/css'); // thread.css
mix.sass('resources/sass/lMCdpjFSu5vMoCSIeycbdokrQqWyPZNLmvjARCwXWC4bkKQCg4BWhlpTQ1gqxMPI.scss', 'public/css'); // lateral_panel.css
mix.sass('resources/sass/LorEh6J3JDeDflokqvfpsYgK7yDIvyMl6qcULvqIgR8qGZ3zkagvsvtpw5pZ1rr8.scss', 'public/css'); // thread_panel.css
mix.sass('resources/sass/lsQ3ucw5ssUvul0bsFuTKR4vEPtw75deUZjctR9D1t3fRu2I1AaBRkhDCrpRFcHW.scss', 'public/css'); // reports.css
mix.sass('resources/sass/MIRPYFD0eaGe3yaFaz6VGq4JxtbowX2Gm6qbV4xV4ChkSnP7viTLiOoaTEhOgFz7.scss', 'public/css'); // new_community.css
mix.sass('resources/sass/MZZkS6zSSswEuYty9HW5AeUDm2Cwi2fd7lO7cZMmjcPf5QsZDNCJLaDf3E0o4QiY.scss', 'public/css'); // configuration.css
mix.sass('resources/sass/PQgOkr0Wv7MpF16BvdG5aGgWNBlx5YF9y3ljjpHwKNESq23IJCczPi1rkXZDfcz1.scss', 'public/css'); // guides.css
mix.sass('resources/sass/q4qRRTPxmFxmP4XImrbCE0RV5M6g1zxkeabuZbe8f3SMElclqBrqZwkuHEHzTEIo.scss', 'public/css'); // new_thread.css
mix.sass('resources/sass/Qaa3sfPYzde0Y65kX1TjRAqH2UvKzsvwoBavOYn43jhy4nbUHon8hW3I23crFrEc.scss', 'public/css'); // tops.css
mix.sass('resources/sass/RUF5xFYFWBPk4UkDWGl0ZfOqJaRw7DbTYQtu3DiqNSwAfv5mP4BXZXCg5xAflVs0.scss', 'public/css'); // user.css
mix.sass('resources/sass/S2t7rF0GaegLEXSHnuJogTw2tv4Po0OXHqSV5RWhUXbHLvNbJ6CoL0FheL5ZrqVL.scss', 'public/css'); // forgot_password.css


mix.combine([
    'resources/js/affiliates.js',
    'resources/js/authenticated.js',
    'resources/js/community.js',
    'resources/js/community_reports.js',
    'resources/js/guides.js',
    'resources/js/newcommunity.js',
    'resources/js/newthread.js',
    'resources/js/non_authenticated.js',
    'resources/js/profile_actions.js',
    'resources/js/register.js',
    'resources/js/reply.js',
    'resources/js/scriptsheet.js',
    'resources/js/thread_actions.js'
], 'public/js/zuv1CthgRAZYP0xk5OBvYDGVjcmt7dyPKmuMq7ixrgFLlPvVTFFldb4mDlohLfLv.js');