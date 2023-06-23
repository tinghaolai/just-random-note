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

    function clearCookie() {
        const cookies = document.cookie.split(";");

        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i];
            const eqPos = cookie.indexOf("=");
            const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
</script>
