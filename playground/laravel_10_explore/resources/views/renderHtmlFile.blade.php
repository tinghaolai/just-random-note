<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body class="antialiased">
    <div id="app">
        Render html file page
        <div>
            <button @click="renderHtmlN()">render n html</button>
            <button @click="renderHtmlRN()">render rn html</button>
            <div v-html="html"></div>
        </div>
    </div>

    </body>
</html>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.14/vue.min.js" integrity="sha512-XdUZ5nrNkVySQBnnM5vzDqHai823Spoq1W3pJoQwomQja+o4Nw0Ew1ppxo5bhF2vMug6sfibhKWcNJsG8Vj9tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                html: '',
            }
        },
        methods: {
            renderHtmlN() {
                axios.get('/getHtmlFileN').then((response) => {
                    this.html = response.data.html;
                });
            },
            renderHtmlRN() {
                axios.get('/getHtmlFileRN').then((response) => {
                    this.html = response.data.html;
                });
            },
        }
    });

</script>
