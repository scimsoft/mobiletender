@extends('layouts.web')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div class="text-center">
                            <h4>Pide directamente desde la mesa</h4>
                            <h5>El cliente escanea el codigo QR inteligente, que le abre directamente la carta digital con su mesa configurado. Hace una seleccion desde la carta digital y cursa el pedido. En la barra y/o cocina salen los tickets de los pedidos para que los camareros lo sirven.</h5>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">

                            <div class="card-body">
                                <table class="table ">
                                    <thead>
                                    <tr>

                                        <th colspan="4" scope="col" class="text-center">Paquete basico</th>

                                    </tr>

                                    </thead>
                                    <tr>
                                        <td><img src="/img/web/icamarera.png" class="img-fluid"></td>

                                        <td class="h5 align-middle"><a href="/web/products/printer" class="nav-link">WebApp ICamarera©</a></td>
                                        <td class="h6 align-middle">Haz que tus clientes pueden  pedir directamente desde su movil desde la Carta Digital en un clic. Mejora las medidas de higiene, ahorra tiempo de esperas a tus camareros y agiliza el proceso de comandas con la Carta Digital para bares, restaurantes y hoteles más moderna del mercado.</td>

                                    </tr>
                                    <tr>
                                        <td><img src="/img/web/QRcode.png" class="img-fluid"></td>
                                        <td class="h5 align-middle"><a href="/web/products/printer" class="nav-link">'Comer aqui'</a>
                                        </td>
                                        <td class="h6 align-middle">Con nuestros codigos QR inteligentes el cliente accede directamente a todo tu carta desde su dispositivo móvil. Con el numero de mesa pre-configurado.</td>

                                    </tr>
                                    <tr>
                                        <td class="h6"><img src="/img/web/printer.gif" class="img-fluid"></td>
                                        <td class="h5 align-middle"><a href="/web/products/printer" class="nav-link">Impresora
                                                Wi-Fi</a></td>
                                        <td class="h6 align-middle">Nuestro impresora Wi-Fi se conecta a su carta digital en el momento que se enciende. Los pedidos de los clientes salen directamente en la Barra y la Cocina.</td>

                                    </tr>
                                    <tr>
                                        <td><img src="/img/web/clickcollect.png" class="img-fluid"></td>
                                        <td class="h5 align-middle"><a href="/web/products/printer"
                                                                       class="nav-link">'Click&Collect'</a></td>
                                        <td class="h6 align-middle">Nuestra webapp hace facil empezar hacer comidas para llevar. Sus clientes pueden pedir directamente desde la carta digital.</td>

                                    </tr>
                                    <tr>
                                        <td><img src="/img/web/logo-personalizado.png" class="img-fluid"></td>
                                        <td class="h5 align-middle"><a href="/web/products/printer" class="nav-link">Nombre y Logo
                                                Personalizado</a></td>
                                        <td class="h6 align-middle"></td>

                                    </tr>
                                    <tr>
                                        <td><img src="/img/web/productos-personalizados.png" class="img-fluid"></td>
                                        <td class="h5 align-middle"><a href="/web/products/printer" class="nav-link">Productos
                                                personablizables</a></td>
                                        <td class="h6 align-middle">Para la gestión de todos los contenidos de tu carta, tienes un panel de gestión sencillo e intuitivo desde el que podrás introducir y modificar toda la información  de productos con fotografías, ingredientes, alérgenos y precios.</td>

                                    </tr>








                                </table>


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
