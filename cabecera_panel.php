<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>RTF Forms Cliente</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/styles_site.css" rel="stylesheet" />


    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="css/select2.css" rel="stylesheet"  />
    <link rel="stylesheet" href="css/zabuto_calendar.css" type="text/css">
    <link rel="stylesheet" href="css/lightbox.css" type="text/css">

    <!-- Favicon -->
	<link rel="icon" type="images/png" href="landing/images/favicon.png">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" crossorigin="anonymous"></script>


    

    <script src="ckeditor/ckeditor.js"></script>


    <style>

        #no-more-tables td {
            max-width: 30px;
        }
        @media only screen and (max-width: 800px) {
            /* Force table to not be like tables anymore */
            #no-more-tables table, 
            #no-more-tables thead, 
            #no-more-tables tbody, 
            #no-more-tables th, 
            #no-more-tables td, 
            #no-more-tables tr { 
                display: block; 
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr { 
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            #no-more-tables tr { border: 1px solid #ccc; }

            #no-more-tables td { 
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee; 
                position: relative;
                padding-left: 50%; 
                white-space: normal;
                text-align:left;
                max-width: 100%;
            }

            #no-more-tables td:before { 
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%; 
                padding-right: 10px; 
                white-space: nowrap;
                text-align:left;
                font-weight: bold;
            }
            #no-more-tables td:before { content: attr(data-title); }
        }


        .bar-chart-bar {
            background-color: #e8e8e8; 
            display: block; 
            position:relative; 
            width: 100%; 
            height: 20px; 
        }
        .bar {
            float: left; 
            height: 100%; 
        }
        .bar1 {
            background-color: green;
        }
        .bar2 {
            background-color: yellow;
        }
        .bar3 {
            background-color: red;
        }   


    </style>

</head>
