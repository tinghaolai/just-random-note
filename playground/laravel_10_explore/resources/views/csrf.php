<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body class="antialiased">
    CSRF page
    <div>
        <button onclick="get()">Get</button>
    </div>
        <div>
        <button onclick="post()">Post</button>
        </div>
    </div>
    <div>
        <button onclick="postWithoutCookie()">Post without cookie</button>
        Post(Y) -> Post without cookie(N) -> Post(N) -> Get(Y, set cookie) -> Post(Y)
        try modify VerifyCsrfToken.php $except to be '*'
    </div>

    <div>
        <button onclick="postWithDifferentPortOrDomain()">Post with different port or domain</button>
        Api route: 127.0.0.1:8000, post with 8001 port or different domain, e.g., <a href="http://localhost:8000/test8">http://localhost:8000/test8</a>
    </div>

    <div>
        <button onclick="postWithDifferentPortOrDomainApi()">Post with different port or domain but not checking middleware</button>
        Api will pass, since in `config/cors.php`, path has 'api/*', and didn't check csrf token
    </div>

    <div>
        <button onclick="setOriginWebCookie()">Set origin web cookie</button>
        click in 127.0.0.1:8000
    </div>

    <div>
        <button onclick="sendFromCrossSite()">Send api from cross site (localhost)</button>
        click in localhost:8000
        Due to the `csrf-frame` below, you can see cookie from 127.0.0.1,
        but there's no way to get cookie from localhost or send the cookie by request
    </div>
    </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function get() {
        axios.get('/test8').then((response) => {
            console.log(response.data);
        });
    }

    function post() {
        axios.post('/test8').then((response) => {
            console.log(response.data);

        });
    }

    function postWithoutCookie() {
        clearCookie();
        axios.post('/test8').then((response) => {
            console.log(response.data);
        });
    }

    function postWithDifferentPortOrDomain() {
        axios.post('http://127.0.0.1:8000/test8').then((response) => {
            console.log(response.data);
        });
    }

    function postWithDifferentPortOrDomainApi() {
        axios.post('http://127.0.0.1:8000/api/test8').then((response) => {
            console.log(response.data);
        });
    }

    function clearCookie() {
        const cookies = document.cookie.split(";");

        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i];
            const eqPos = cookie.indexOf("=");
            const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }

    function setOriginWebCookie() {
        document.cookie = 'abc=from origin';

        axios.post('http://127.0.0.1:8000/api/test9').then((response) => {
            console.log(response.data);
        });
    }

    function sendFromCrossSite() {
        document.cookie = 'abc=from cross site';

        axios.post('http://127.0.0.1:8000/api/test9').then((response) => {
            console.log(response.data);
        });
    }
</script>

<iframe style="display:none" name="csrf-frame"></iframe>
<form method='POST' action='http://127.0.0.1:8000/api/test9' target="csrf-frame" id="csrf-form">
  <input type='submit' value='submit'>
</form>
<script>document.getElementById("csrf-form").submit()</script>
