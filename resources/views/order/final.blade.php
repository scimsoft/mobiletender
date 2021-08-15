@extends('layouts.menu')

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
                    <H2>Gracias por su confianza</H2>
<br>
                    <H4>Ayudanos y deja su opinion <a href="https://g.page/r/CXvfi6vXp5UmEAg/review">Aqui</a></H4>

                    <br>

                        <H4>Pulsa <a href="javascript:set_notificacion();">aqui</a> para recibir nuestras ofertas.</H4>

                    <br>
                    <br>
                       <h4> <a href="/order">Volver</a></h4>



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