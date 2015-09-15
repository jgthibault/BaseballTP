<?php
    // Start the session
    session_start();
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MaCave | Mes vins</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/datatable.min.css" />
    <script src="js/vendor/modernizr.js"></script>
    <script src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
    <?php
        /* Object */
        include("php/Session.php");
        include("php/MySql.php");
		
        include("large_menu.php");
        include("small_menu_start.php");

        $mySql = new MySql();
    ?>

            <!-- MAIN SECTION -->
            <section class="main-section">
                
                <div class="row">
                    <h4>MES VINS</h4>
                </div>
                <div class="row">
                    <div class="small-12 columns">
                        <table id="example" width="100%">
                            <thead>
                            <tr>
                                <th>NOM</th><th>COULEUR</th><th class="show-for-medium-up">PASTILLE</th><th>NOTE</th><th>PRIX</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>RH Philips</td><td>Rouge</td><td class="show-for-medium-up">Aromatique et souple</td><td>8</td><td>15.95$</td>
                            </tr>
                            <tr>
                                <td>Bourbon</td><td>Blanc</td><td class="show-for-medium-up">Aromatique et ample</td><td>8</td><td>16.00$</td>
                            </tr>
                            <tr>
                                <td>RH Philips</td><td>Rouge</td><td class="show-for-medium-up">Aromatique et souple</td><td>8</td><td>15.10$</td>
                            </tr>
                            <tr>
                                <td>RH Philips</td><td>Rouge</td><td class="show-for-medium-up">Aromatique et souple</td><td>8</td><td>15.95$</td>
                            </tr>
                            <tr>
                                <td>RH Philips</td><td>Rouge</td><td class="show-for-medium-up">Aromatique et souple</td><td>8</td><td>15.95$</td>
                            </tr>
                            <tr>
                                <td>Bourbon</td><td>Blanc</td><td class="show-for-medium-up">Aromatique et ample</td><td>8</td><td>16.00$</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="paging"></div>
                    </div>
                </div>

            </section>
    <?php
        include("small_menu_end.php");

    ?>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/datatable.min.js"></script>
    <script>
        $(document).foundation();

        $('#example').datatable({
            pageSize: 5,
            sort: [true, true, true,true,true],
            filters: [true, true, 'select', true, true],
            filterText: 'Filtre '
        }) ;
</script>
</body>
</html>