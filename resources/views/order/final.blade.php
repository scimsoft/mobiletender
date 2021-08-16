@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">


                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <img src="/img/logo.png" class="img-fluid">
                        <br><br>
                    <H2>Gracias por su confianza</H2>
<br>
                    <H4>Ayudanos y deje su opinion en <a href="https://g.page/r/CXvfi6vXp5UmEAg/review" target="_blank">Google</a></H4>
                    <br>
                        Sigeunos en:
                        <a href="https://www.instagram.com/playaalta/" class="bi bi-instagram"><span class="label">Instagram</span></a>

                            <a href="https://twitter.com/playaalta" class="bi bi-twitter"><span class="label">Twitter</span></a>
                            <a href="https://www.facebook.com/chiringuito.playa.alta" class="bi bi-facebook"><span class="label">Facebook</span></a>


                    <br><br>

                        <H4>Pulsa <a href="javascript:set_notificacion();">aqui</a> para recibir nuestras ofertas.</H4>

                    <br>
                    <br>




                </div>
            </div>

        </div>
    </div>



@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
jQuery(document).ready(function () {



})
function set_notificacion(){
    Notification.requestPermission().then(function (permission) {
        // If the user accepts, let's create a notification
        if (permission === "granted") {
            var notification = new Notification("Bienvenido al mundo @Playaalta");
        }
    });
}


</script>