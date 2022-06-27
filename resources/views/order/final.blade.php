@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
<br><br>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <img src="/img/PLAYAALTA_30Years.png" class="img-fluid">
                        <br><br>
                    <H2>Gracias por 30 años eligiendo nos.</H2>
<br>
                    <H4>No olvides dejar tu opinion en </H4><a href="https://g.page/r/CXvfi6vXp5UmEAg/review" target="_blank"> <img src="/img/reviews.png" width="150px"></a>
                    <br><br><br>
                        Y siguenos en:<br>
                        <a href="https://www.instagram.com/playaalta/" class="bi bi-instagram" target="_blank"><span class="label"><img src="/img/Instagram_icon.png" width="32px"></span></a>

                            <a href="https://twitter.com/playaalta" class="bi bi-twitter" target="_blank"><span class="label"><img src="/img/Twitter_icon.png" width="32px"></span></a>
                            <a href="https://www.facebook.com/chiringuito.playa.alta" class="bi bi-facebook" target="_blank"><span class="label"><img src="/img/Facebook_icon.png" width="32px"></span></a>



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

function set_notificacion(){
    Notification.requestPermission().then(function (permission) {
        // If the user accepts, let's create a notification
        if (permission === "granted") {
            var notification = new Notification("Bienvenido al mundo @Playaalta");
        }
    });
}


</script>
