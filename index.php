<?php
    require 'vendor/autoload.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body class="bg-black">
    <div class="container bg-white pb-3 rounded" >
        <div class="border-bottom bg-black  rounded-bottom my-3 p-3">
            <h4 class="text-center bg-transparent bg-opacity-0 text-white my-3 p-1">Welcome</h4>
            <h1 class="text-center bg-transparent bg-opacity-0 text-white m-2 p-1">Full Stack Developer</h1>
            <h2 class="text-center bg-transparent bg-opacity-0 text-white m-2 p-1">Johnny Daniel Aracena Araya</h2>
            <h6 class="text-center bg-transparent bg-opacity-0 text-white m-2 p-1">johnny.aracena@gmail.com | 807 407 9272 | Ontario | Canada</h6>
        </div>

        <div class = "card  col row  justify-content-center bg-white text-opacity-100  m-4 border-0 border-right">
            <div class="card card-header bg-transparent border-0">
                <h3 class="text-black opacity-75 shadow">EXPERIENCE</h3>
            </div>

            <div  class="card card-body d-flex justify-content-center align-content-center justify-content-around p-4 bg-white border-0 bg-opacity-25">
                <div class="row p-2">
                    <div class="col-12 col-lg-4 mx-auto card border-0  p-4 text-center">
                        <h3 class=" text-center ">Universidad de La Serena University</h3>
                        <div class="card-body text-left">
                            <div>
                                <div class="text-left">
                                    <p >Creation of a web platform for the control and reporting of expenses of university projects.</p>

                                    <ul class="text-md-left">
                                        <li>Analyzed, designed, developed, tested, and implemented financial application for manage and control project expenses.</li>
                                        <li>Reduction of the time of analysis and processing expenses of the projects from 1 month of work to 1 day of work.</li>
                                        <li>Web application based on Php, JavaScript, Ajax, jQuery, Bootstrap, CSS, HTML, Oracle.</li>
                                    </ul>
                                    <h4 class="card-title">Products</h4>
                                    <ul>
                                        <li>Indexation and relation of documents interface</li>
                                        <li>Document Finder and navigator</li>
                                        <li>Categorization of types of purchases</li>
                                        <li>Operational efficiency KPIs</li>
                                        <li>Transfer of interannual budgets</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mx-auto mr-2 card border-0 shadow  " >
                        <div class="card-body col">


                            <div class="d-flex col">
                                <div class="w-50 text-center">
                                    <img class="img-fluid img-thumbnail" src="include/img/universidad-la-serena.jpg"  onclick="showUls1()">
                                </div>
                                <div class="w-50 text-center">
                                    <img class="img-fluid img-thumbnail" src="include/img/documents-link.png"  onclick="showUls2()">
                                </div>

                            </div>
                            <div class="d-flex col">

                                <div class="w-100 text-center">
                                    <img class="img-fluid img-thumbnail" src="include/img/KPI.png"  onclick="showUls3()">
                                </div>

                            </div>

                            <div class="modal fade  m-auto" tabindex="-1" role="dialog" id="modal-uls1">
                                <div class="modal-dialog modal-lg " role="document">

                                    <div class="modal-content h5" style="height: 40em; width: 60rem">
                                        <div class="col-12 modal-body h-100">
                                            <div class="modal-header bg-white w-100">
                                                Universidad de La Serena University Main building
                                            </div>
                                            <img class="w-100" src="include/img/universidad-la-serena.jpg" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade  m-auto" tabindex="-1" role="dialog" id="modal-uls2">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content h5" style="height: 40em; width: 60rem">
                                        <div class="modal-header bg-white w-100">
                                            Indexation and relation of documents interface
                                        </div>
                                        <div class="col-12 modal-body w-100 text-center">
<!--                                            <iframe class="w-100 h-100" src="http://216.211.50.2:8000" style="height: 30rem"></iframe>-->
                                            <img src="include/img/documents-link.png" style="height: 30rem">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade  m-auto" tabindex="-1" role="dialog" id="modal-uls3">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content h5" style="height: 40em; width: 60rem">
                                        <div class="modal-header bg-white w-100">
                                            Operational efficiency KPIs
                                        </div>
                                        <div class="col-12 modal-body w-100 text-center">
                                            <!--                                            <iframe class="w-100 h-100" src="http://216.211.50.2:8000" style="height: 30rem"></iframe>-->
                                            <img src="include/img/KPI.png" style="height: 30rem">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div  class="card card-body d-flex justify-content-center align-content-center justify-content-around p-4 bg-white border-0 bg-opacity-25">
                <div class="row p-2 flex-row-reverse">
                    <div class="col-12 col-lg-4 mx-auto card border-0  p-4 text-center">
                                <h3 class=" text-center ">Visiion Ingenieria Limitada</h3>
                        <div class="card-body text-left">
                            <div>
                                <div class="text-left">
                                   <p>Creation of a module for the role of receptionist in the center of medical specialties and social services for the Ciudad Mujer project of the government of Paraguay.</p>

                                    <ul class="text-md-left">
                                        <li>Analyzed, designed, developed, tested, and implemented full schedule web application at the "Ciudad Mujer (Woman City)" project.</li>
                                        <li>The scheduling module allows for the creation of booking routes for multiple medicals disciplines in an average time of 1:30 minutes.</li>
                                        <li>Application design database, interfaces, and APIS. Web application based on Laravel, jQuery, Bootstrap, CSS, and HTML.</li>
                                    </ul>
                                    <h2 class="m-2">Click on the image to tray it.</h2>
                                    <h6>User ids: 1, 2, 3, 4, 11, 13</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mx-auto mr-2 card border-0 shadow  " >
                        <div class="card-body col">
                            <div class="w-100 text-center">
                                <img class="img-fluid img-thumbnail" src="include/img/CiudadMujer_Calendar.png"  onclick="showVisiion()">
                            </div>
                            <div class="text-center">
                                (app for sample test purpose only)
                            </div>
                            <div class="modal fade  m-auto" tabindex="-1" role="dialog" id="modal-visiion">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content h5" style="height: 40em; width: 60rem">
                                        <div class="col-12 modal-body h-100">
                                            <iframe class="w-100 h-100" src="http://216.211.50.2:8000" style="height: 30rem"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div  class="card card-body d-flex justify-content-center align-content-center justify-content-around p-4 bg-white border-0 bg-opacity-25">
                <div class="row p-2  d-flex ">
                    <div class="col-12 col-lg-4 mx-auto card border-0  p-4 text-center">
                        <h3 class=" text-center ">Free Lance</h3>
                        <div class="card-body text-left">
                            <div>
                                <div class="text-left">
                                    <p>Web application for the mining machinery company Bacor, for inventory management and maintenance of mining and construction machinery and equipment.
                                    </p>
                                    <ul class="text-md-left">
                                        <li>Calculation of costs per hour of work</li>
                                        <li>Configuration of maintenance plans by hour of work and/or kilometres</li>
                                        <li>Visual warning alarm indicating the next maintenance</li>
                                        <li>Reports of operating costs of the fleet of machinery and equipment</li>
                                        <li>Programming of preventive and corrective maintenance</li>
                                        <li>Application design database, interfaces, and APIS. Web application based on Laravel, jQuery, Bootstrap, CSS, HTML and MySQL.</li>
                                    </ul>


                                    <h2 class="m-2">Click on the image to tray it.</h2>
                                    <h6>User: test@test-bacor-app.com</h6>
                                    <h6>Pass: test123</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 mx-auto mr-2 card border-0 shadow  " >
                        <div class="card-body col">
                            <div class="w-100 text-center">
                                <img class="img-fluid img-thumbnail" src="include/img/Bacor1.png"  onclick="showBacor()">
                            </div>
                            <div class="w-100 text-center mt-1">
                                <img class="img-fluid img-thumbnail" src="include/img/Bacor2.png"  onclick="showBacor()">
                            </div>
                            <div class="text-center">
                                (app for sample test purpose only)
                            </div>
                            <div class="modal fade  m-auto" tabindex="-1" role="dialog" id="modal-bacor">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content h5" style="height: 40em; width: 60rem">
                                        <div class="col-12 modal-body h-100">
                                            <iframe class="w-100 h-100" src="http://216.211.50.2:8001" style="height: 30rem"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



<!--        <div class = "card  col row  justify-content-center bg-white text-opacity-100  m-4 border-0 border-right">-->
<!--            <div class="card card-header bg-transparent">-->
<!--                <h3 class="text-black opacity-50">PERSONAL PROJECTS</h3>-->
<!--            </div>-->
<!--            <div class="card card-body d-flex justify-content-center align-content-center justify-content-around p-4 bg-secondary bg-opacity-25">-->
<!--                <div class="row">-->
<!--                    <div class=" col-3 mx-auto card border-0 shadow ">-->
<!--                        <div class="row card card-header bg-primary text-break text-shadow-3 text-bg-warning bg-opacity-10  border-0">-->
<!--                            <div class="card card-header bg-info text-break text-shadow-3 text-bg-warning bg-opacity-10 border-0">-->
<!--                                <h3 class="mx-3"></h3>-->
<!--                                <div class="form-control bg-secondary border-0 shadow bg-opacity-10 ">-->
<!--                                    <h6 class=" text-opacity-100">Universidad de La Serena University. Oct 2018 to Dec 2020</h6>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-3 mx-auto card   borser-0">-->
<!--                        <div class="row card card-header bg-primary text-break text-shadow-3 text-bg-warning bg-opacity-10  border-0">-->
<!--                            <div class="card card-header bg-info text-break text-shadow-3 text-bg-warning bg-opacity-10 m-0 border-0">-->
<!--                                <h3 class="mx-3"></h3>-->
<!--                                <div class="form-control bg-secondary border-0 shadow bg-opacity-10 ">-->
<!---->
<!--                                    <h6 class=" text-opacity-100">Cencosud. Oct 2018 to Dec 2020</h6>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-3 mx-auto card border-0 shadow">-->
<!--                        <div class="row card card-header bg-primary text-break text-shadow-3 text-bg-warning bg-opacity-10  border-0">-->
<!--                            <div class="card card-header bg-info text-break text-shadow-3 text-bg-warning bg-opacity-10  border-0">-->
<!--                                <h3 class="mx-3"></h3>-->
<!--                                <div class="form-control bg-secondary border-0 shadow bg-opacity-10 ">-->
<!---->
<!--                                    <h6 class=" text-opacity-100">Vision Oct 2018 to Dec 2020</h6>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="card-body">-->
<!---->
<!--                            <br>-->
<!--                            <br><br><br><br><br><br><br>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!---->
<!--            </div>-->
<!---->
<!--        </div>-->

    </div>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript">
        $(function() {
       //     $('#myModal').modal('show');
        });
        function showVisiion(){
           $('#modal-visiion').modal('show');
            $('#modal-visiion').modal('handleUpdate')


        }

        function showBacor(){
            $('#modal-bacor').modal('show');
            $('#modal-bacor').modal('handleUpdate')


        }
        function showUls1(){
            $('#modal-uls1').modal('show');
            $('#modal-uls1').modal('handleUpdate')
        }
        function showUls2(){
            $('#modal-uls2').modal('show');
            $('#modal-uls2').modal('handleUpdate')
        }

        function showUls3(){
            $('#modal-uls3').modal('show');
            $('#modal-uls3').modal('handleUpdate')
        }
    </script>
</body>
</html>