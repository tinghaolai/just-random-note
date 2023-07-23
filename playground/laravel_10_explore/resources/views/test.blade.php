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
        <button onclick="test14()">test14</button>
    </div>
    <div>
        <button onclick="test15_1()">test15 set session</button>
    </div>
    <div>
        <button onclick="test15_2()">test15 get session</button>
    </div>

    <div>
        <a href="http://localhost:8000/sso/test15">to sso</a>
    </div>

    <div>
        <button onclick="testGet('/test18')">test18 error log</button>
    </div>

    <div>
        <button onclick="testGet('/test18-2')">catch exception</button>
    </div>
    </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function test14() {
        axios.get('/test14').then((response) => {
            console.log(response.data);
        });
    }

    function test15_1() {
        axios.get('/test15-1').then((response) => {
            console.log(response.data);
        });
    }

    function test15_2() {
        axios.get('/test15-2').then((response) => {
            console.log(response.data);
        });
    }

    function testGet(path) {
        axios.get(path).then((response) => {
            console.log(response.data);
        });
    }
</script>
