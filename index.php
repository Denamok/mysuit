<?php
	$db = null;
	function get_db() {
                global $db;
		if(!$db){
                        require "config.php";
                        $db = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
			//$db = new PDO('sqlite:cars.db');
                }
		return $db;
	}

	function get_images() { 
		$file_db = get_db();
		$id_where = "";
		$where = "";
		$vals = array();
		$id_vals = array();

		if($_GET['search'] != "")  {
		 	$words = explode(" ", $_GET['search']);
			
			$id_where = " WHERE i.img_id = t.img_id AND ";
			#VERY rudimentary BAD search function for search queries. Also, very inefficient when scaled.
			#just for purposes of demo
			foreach($words as $word) { 
				$word = "%$word%";
				//$id_where .= "make LIKE ? OR model LIKE ? OR year LIKE ? OR condition LIKE ? OR color LIKE ? OR ";
				$id_where .= "t.tag LIKE ? OR i.file_name LIKE ? OR i.title LIKE ? OR ";
				array_push($id_vals, $word, $word, $word);
			}

			$id_where = substr($id_where, 0, -3);
		}

		#inefficient to select all matches and then filter down. purely for demo and to
		#have faceted query on its own for demonstration. Look into elasticsearch or solr for efficient faceting!
		$stmt = $file_db->prepare("SELECT DISTINCT i.img_id FROM plus2net_image as i, tags as t $id_where");
		$stmt->execute($id_vals);

		$ids_list = "";
		while($car = $stmt->fetch()) { 
			$ids_list .= $car['img_id'] . ",";	
		}
		$ids_list = substr($ids_list, 0, -1);

		#return if we got no results from search!
		if($ids_list == "") { 
			return $stmt;
		}

		unset($_GET['search']);

		#if we have facets
		if(count($_GET) > 0) { 

			#handle specialCases
			if($_GET['onlyPhotos'] == "1") { 
				$where .= " AND image!='' ";	
				unset($_GET['onlyPhotos']);
			}

			if($_GET[minPrice] != "") { 
				$where .= " AND price >= $_GET[minPrice] ";
			}

			if($_GET[maxPrice] != "") { 
				$where .= " AND price <= $_GET[maxPrice] ";
			}

			unset($_GET[minPrice]);
			unset($_GET[maxPrice]);

			if($_GET[minYear] != "") {
				$where .= " AND year >= $_GET[minYear] ";
			}


			if($_GET[maxYear] != "") {
				$where .= " AND year <= $_GET[maxYear] ";
			}

			unset($_GET[minYear]);
			unset($_GET[maxYear]);

			if($_GET[owner] != "") {
				$where .= " AND o.owner = '$_GET[owner]'";
			}
			unset($_GET[owner]);


			if($_GET[period] != "") {
				$where .= " AND p.period = '$_GET[period]'";
			}
			unset($_GET[period]);

			if($_GET[frequently_added] != "") {
				$where .= " AND i.date > (DATE_SUB(CURDATE(), INTERVAL 1 WEEK))";
			}
			unset($_GET[frequently_added]);



			foreach($_GET as $key=>$value) {


				if(is_array($value)) {
                                        if ($key == "tag"){
     					   $where .= " AND t.img_id = i.img_id AND t.$key IN (";
                                        } else {
     					   $where .= " AND $key IN (";
                                        }
					foreach($value as $el) { 
						$where .= "?,";
						array_push($vals, $el);
					}
					$where = substr($where, 0, -1);
					$where .= ") ";
				}
				else { 
					$where .= " AND $key=? ";
					array_push($vals, $value);
				}
			}
		}
		$stmt = $file_db->prepare("SELECT DISTINCT i.title, o.owner, p.period, i.img_id, i.file_name FROM plus2net_image as i, owners as o, tags as t, periods as p WHERE p.img_id = i.img_id AND o.img_id = i.img_id AND i.img_id IN ($ids_list) $where ORDER BY i.date DESC");
		$stmt->execute($vals);

		return $stmt;
	}

	function grid_view($stmt) { 
		$string = "";
		while ($car = $stmt->fetch()) {
                        $file_db = get_db();
     		        $stmt_tags = $file_db->prepare("SELECT tag FROM tags WHERE img_id = $car[img_id]");
		        $stmt_tags->execute();

			//$conds = explode("_", $car[file_name]);
			
			//$condition = ucfirst($conds[0]);
			$condition = "";

                        while ($tag = $stmt_tags->fetch()) {
                         	$condition .= " " . $tag[tag];
                        }
			//if(count($conds) > 1) { 
			//	$condition .= " " . ucfirst($conds[1]);
			//}

                        $name = $car[title];
			if($name == "") { 
				$name = $car[file_name];
			}

			$image = $car[file_name];
			if($image == "") { 
				$image = "no_image.jpg";
			}

                        $period = $car[period];

			$string .= "
				<div class='col-md-4 col-sm-6'>
                            <div class='thumbnail fancybox'>
                                        <img class='thumbnail' alt='' src='upload/$image'>
                                    <span class='label label-success'>" . $car[owner] . "</span>
                                    <div class='caption'>
                                        <h4 class='title'><a href=''>$name</a></h4>
                                        <ul class='list-unstyled'>
                                            <li><span><strong>Époque :</strong> " . $period . "</span>
                                            </li>
                                            <li><span><strong>Tags :</strong> " . $condition . "</span>
                                            </li>
                                            <li><span class='remove' style='display:none'><a href='#' onclick='removeImage(\"" . $car[img_id] . "\")'><img src='images/trash.png'></a></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
								</div>
								";
		}	

		if($string == "") { 
			$string = "<h3 style='text-align:center'>NO RESULTS</h3>";
		}

		return $string;
	}


	function get_tags(){ 
		$file_db = get_db();
                return $file_db->query('SELECT DISTINCT tag FROM tags ORDER BY tag ASC');
	}

	function get_owners () { 
		$file_db = get_db();
		return $file_db->query('SELECT DISTINCT owner FROM owners ORDER BY owner ASC');
	}

	function get_periods () { 
		$file_db = get_db();
		return $file_db->query('SELECT DISTINCT period FROM periods ORDER BY period ASC');
	}

	if($_GET["ajax"] == "true") {
		unset($_GET['ajax']);
		echo grid_view(get_images());
		exit;
	}

?>
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

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <form class="navbar-form navbar-left" role="search" action="index.php">
                        <div class="form-group">
							<input name="search" type="text" class="form-control input-lg" placeholder="Rechercher un élément de costume..." value="<?php echo $_GET['search'] ?>">
                        </div>
                    </form>







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
                            <li class="active"><a href="#">Home</a>
                            </li>
                            <li><a href="upload.php">Ajouter un élément de costume</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
        </div>




        <div class="container">





            <div class="row">

                <div class="col-md-3 col-sm-4"> 
                    <!-- left sec -->
                    <div class="left-sec">



                        <div class="left-cont">
                            <h6><span class="glyphicon glyphicon-search"></span> Affiner votre recherche</h6>
			   <form class="filter-sec" id="facets">

                                <select name="owner" class="form-control">
                                    <option value="">Propriétaire</option>

									<?php
										$result = get_owners();
										foreach ($result as $m) {
									?>
											<option value="<?php echo $m['owner'] ?>"><?php echo $m['owner'] ?></option>
									<?php
										}
									?>
                                </select>


                                <select name="period" class="form-control">
                                    <option value="">Époque</option>

									<?php
										$result = get_periods();
										foreach ($result as $m) {
									?>
											<option value="<?php echo $m['period'] ?>"><?php echo $m['period'] ?></option>
									<?php
										}
									?>
                                </select>

				<h5>Tags :</h5>
				  <div class="tags input-control tags">
									<?php
										$result = get_tags();
										foreach ($result as $m) {
									?>
									      <input name="tag[]" class="checkbox" id="<?php echo $m['tag'] ?>" type="checkbox" value="<?php echo $m['tag'] ?>" />
                                                                              <label for="<?php echo $m['tag'] ?>"><?php echo $m['tag'] ?></label>
									<?php
										}
									?>


                                </div>

                            </form>
                        </div>






                    </div>
                    <!-- /left sec -->
                </div>


                <div class="col-md-9 col-sm-8">
                    <div class="right-sec">


                        <div class="top">
                            <ul class="nav nav-tabs tooltip-demo">
                                <?php
				if ($_GET['frequently_added'] != '') {?>
				<li>
				<?php
				} else {?>
				<li class="active">
				<?php } ?>
                                <a href="index.php">Tous les éléments</a>
                                </li>
                                <?php
				if ($_GET['frequently_added'] != '') {?>
				<li class="active">
				<?php
				} else {?>
				<li>
				<?php } ?>
				<a href="index.php?frequently_added=true">Ajoutés récemment</a>
                                </li>
                            </ul>
                        </div>




                        <div class="row" id="searchCont">

							<?php echo grid_view(get_images()); ?>


                            <hr>


                        </div>
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
                <li><a href="https://github.com/Denamok/mysuit">Git</a>
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

                beforeShow: function(){
  			$(".remove").show();
		},

		afterClose: function(){
  			$(".fancybox").show();
  			$(".remove").hide();
		}

	     });

        });
    </script>
    <!-- /Javascript -->



</body>

</html>
