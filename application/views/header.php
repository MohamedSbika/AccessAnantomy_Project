<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="BonGest">
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GRLDWS8QBM"></script>
<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- jQuery Validation Plugin -->
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/additional-methods.min.js"></script> -->

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GRLDWS8QBM');
</script>
    <?php
  
    if(isset($page)){
        $meta = '';
        $indx = '';
        $this->load->helper('html');
        switch ($page){
            case 'livreCours' :
                if($OneBook[0]["indexKeysCurs"]!=''){$indx = ', '.$OneBook[0]["indexKeysCurs"];}
                $meta = array( array('name' => 'keywords', 'content' => 'site web, plateforme'.$indx) );
                break;

            case 'livreResume' :
                if($OneBook[0]["indexKeysResum"]!=''){$indx = ', '.$OneBook[0]["indexKeysResum"];}
                $meta = array( array('name' => 'keywords', 'content' => 'site web, plateforme'.$indx) );
                break;

            case 'livreQcm' :
                if($OneBook[0]["indexKeysQcm"]!=''){$indx = ', '.$OneBook[0]["indexKeysQcm"];}
                $meta = array( array('name' => 'keywords', 'content' => 'site web, plateforme'.$indx) );
                break;

            case 'livreQroc' :
                if($OneBook[0]["indexKeysQroc"]!=''){$indx = ', '.$OneBook[0]["indexKeysQroc"];}
                $meta = array( array('name' => 'keywords', 'content' => 'site web, plateforme'.$indx) );
                break;

            case 'livre' :
                if($OneBook[0]["indexKeysBook"]!=''){$indx = ', '.$OneBook[0]["indexKeysBook"];}
                $meta = array( array('name' => 'keywords', 'content' => 'site web, plateforme'.$indx) );
                break;

            default :
                $meta = array( array('name' => 'description', 	'content' => 'Plateforme educative') );
                break;
        }

        echo meta($meta);
    }
    ?>
    <link rel="shortcut icon" href="<?php echo HTTP_IMAGES; ?>icons/favicon.ico" />

    <title>Access Anatomy</title>

    <link href="<?php echo HTTP_CSS; ?>app.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_JS; ?>DataTables/datatables.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_JS; ?>Zoom/zoomove.min.css"/>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
    -->

</head>
<style>
    .content {
        padding-top: 0%;
        /*padding-right: 7%;*/
        padding-bottom: 0%;
        /*padding-left: 7%;*/
        /*background-color: white;*/
    }
    .main{
        background-color: white !important;
    }
    .breadcrumb{
        margin-bottom: 0rem;
    }
    .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        color: #cc0000;
    }
</style>
