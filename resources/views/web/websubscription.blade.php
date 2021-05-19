@extends('layouts.web')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>
                            <h4  class="text-center">Paquete Simple</h4>
                            <h5>Pide para recoger</h5>
                            <h6 class="text-justify">El cliente mediante la carta digital puede hacer su pedido, y recogerlo en su local. </h6>


                        </div>
                    </div>
                    <div class="card-body">
                        <div id="paypal-button-container-P-9V296912CN337582HMCR6YIQ"></div>
                        <script src="https://www.paypal.com/sdk/js?client-id=AZyvXbi1xfnLIyB9AKQZBsxE-yfeNlcy3VJtU6kzeoiSSVIq7bxHhFamOv2t4u9KMh5s4BasKByCLP4L&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                        <script>
                            paypal.Buttons({
                                style: {
                                    shape: 'pill',
                                    color: 'gold',
                                    layout: 'vertical',
                                    label: 'paypal'
                                },
                                createSubscription: function(data, actions) {
                                    return actions.subscription.create({
                                        /* Creates the subscription */
                                        plan_id: 'P-9V296912CN337582HMCR6YIQ'
                                    });
                                },
                                onApprove: function(data, actions) {
                                    alert(data.subscriptionID); // You can add optional success message for the subscriber here
                                }
                            }).render('#paypal-button-container-P-9V296912CN337582HMCR6YIQ'); // Renders the PayPal button
                        </script>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
