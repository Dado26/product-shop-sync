<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Test - Product</title>

        <!-- Custom fonts for this template-->
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>

    <body>

        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="h1 mt-5">Test - Product</div>
                        <div class="card-body">

                            <div class="border h4 title mt-3" id="product-title">Lampa za insekte</div>

                            <div class="product-description border h4 mt-3">
                                Napravljena specijalno za uništavanje letećih štetnih insekata.
                            </div>

                            <div class="product-price border h4 mt-3">Cena: 1899.00 din</div>

                            <div class="product-stock border h4">In stock</div>

                            <div class="product-images border mt-3">
                                <div class="h4">list of images</div>
                                <img itemprop="image" src="http://www.elementa.rs/images/products/57562/original/1.jpg" alt="Lampa za insekte 1x6W" width="200">
                                <img itemprop="image" src="http://www.elementa.rs/images/products/57562/original/2.jpg" alt="Lampa za insekte 1x6W" width="200">
                                <img itemprop="image" src="http://www.elementa.rs/images/products/57562/original/3.jpg" alt="Lampa za insekte 1x6W" width="200">
                            </div>

                            <div class="variants">
                                <div class="color">Blue</div>
                                <div class="color">White</div>
                                <div class="color">Black</div>
                            </div>

                            <div class="sku">
                                SKU: 123ABC
                            </div>

                            <div class="mt-3">
                                <div class="h4">Specs table</div>
                                <table class="tbl-technical-data table-bordered" id="product-specs">
                                    <tr>
                                        <td>Brend</td>
                                        <td>MITEA</td>
                                    </tr>
                                    <tr>
                                        <td>Namena</td>
                                        <td>Za insekte</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
