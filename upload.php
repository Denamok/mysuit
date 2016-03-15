<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MySuit</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Fancybox -->
    <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />


    <!-- Custom CSS Assets -->

    <link href="assets/css/scojs.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.fs.picker.css">
    <link href="assets/css/jquery.fs.selecter.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.fs.scroller.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link href="assets/css/theme.css" rel="stylesheet">


</head>

<body>


    <!-- /Wrap -->
    <div id="wrap">

        <div id="login" class="collapse">
            <div class="container">
                <div class="top-form-inner">

                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail2">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword2">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                        </div>
                        <a href="#" class="btn btn-primary">Login</a>
                    </form>
                </div>
            </div>
        </div>

        <nav class="navbar  navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><span class="logo"><img class="logo" src="images/hanger.png"></span> My<span class="sec-brand">Suit</span></a>
                </div>

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>


        <div id="top">
            <nav class="secondary navbar navbar-default" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex5-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-ex5-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php">Home</a>
                            </li>
                            <li class="active"><a href="upload.php">Ajouter un élément de costume</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
        </div>




        <div class="container">





            <div class="row">



                <div class="col-md-9 col-sm-8">
                    <div class="right-sec">

<form action='uploadck.php' method=post target='myiframe' enctype='multipart/form-data' >
<input type=hidden name=todo value='upload'>
<br><br><br>

<div>
<div class="upload">Insérer une image :</div>
<div class="upload"><input type=file name='userfile[]' multiple><input type=submit value="Envoyer l'image"></div>
</div>

</form>

<iframe name='myiframe' src='uploadck.php' width="1200" height="600" frameBorder="0"> </iframe>


                    </div>
                </div>
            </div>



            <hr>






            <hr>



        </div>
        <!-- /.container -->





        <div class="sub-foot">



    </div>

    <!-- /Wrap -->



    <!-- Footer -->

    <div id="footer">
        <div class="container">

            <ul class="list-inline">
                <li><a href="index.php">Home</a>
                </li>
                <li><a href="#">Git</a>
                </li>
            </ul>
            <p class="text-muted credit">&copy; 2016 <strong>Topik</strong> &middot; 
            </p>
        </div>
    </div>

    <!-- /Footer -->




    <!-- javascript -->
    <script src="js/jquery.min.js"></script>
    <script type='text/javascript' src='js/jquery.deserialize.js'></script> 
    <script type='text/javascript' src='js/jquery.facets.js'></script>
    <script type='text/javascript' src='js/demo.js'></script>

    <!-- Fancybox -->
    <script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>






    <script src="assets/js/jquery.fs.selecter.js"></script>
    <script src="assets/js/jquery.fs.picker.js"></script>
    <script src="assets/js/jquery.fs.scroller.js"></script>

    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sco.modal.js"></script>
    <script src="assets/js/sco.confirm.js"></script>
    <script src="assets/js/sco.ajax.js"></script>
    <script src="assets/js/sco.collapse.js"></script>
    <script src="assets/js/sco.countdown.js"></script>
    <script src="assets/js/sco.message.js"></script>





    <script>
        tarGet = "";

        $(document).ready(function (e) {




            $(".selecter_label_1").selecter({
                defaultLabel: "Select a Make"
            });

            $(".selecter_label_2").selecter({
                defaultLabel: "Select A Model"
            });

            $(".selecter_label_3").selecter({
                defaultLabel: "Condition"
            });

            $(".selecter_label_4").selecter({
                defaultLabel: "Transmission"
            });

            $("input[type=checkbox], input[type=radio]").picker();
 
            $(".fancybox").fancybox({

		afterClose: function(){
  			$(".fancybox").show();
		}

	     });

        });
    </script>
    <!-- /Javascript -->



</body>

</html>
