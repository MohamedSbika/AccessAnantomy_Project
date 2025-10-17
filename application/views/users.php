<?php
include('header.php');
?>
<style>
checkbox{
  vertical-align:middle;
}
</style>

        <div class="my-3 my-md-2">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                   <a href="<?php echo base_url(); ?>">Accueil</a> &nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp; Users
              </h1>
            </div> 
             <div class="row" style="width:100%;margin: 0 auto;">
                <div class="card">
                  
                  <div class="card-header" style="background-color: #d4d4d4;width:100%;">
                       
                        <div class="col-md-12">                                                                           
                               <form class="form-inline" name="com_form" id="com_form" action="/action_page.php" style="width:100%;padding-top:5px;padding-bottom:5px;">     
                                  <div class="form-group">
                                    <label for="login" style="text-align:right;padding-right:5px;padding-left:5px;justify-content: flex-end;">Login  : </label>
                                    <input type="text" id="login" name="login" class="form-control form-control-sm dt-pick" style="width:100px;">
                                  </div>           

                                  <!-- <div class="form-group">
                                    <label for="firstname" style="text-align:right;padding-right:5px;padding-left:5px;justify-content: flex-end;">First Name  : </label>
                                    <input type="text" id="firstname" name="firstname" class="form-control form-control-sm dt-pick" style="width:100px;">
                                  </div>           

                                  <div class="form-group">
                                    <label for="lastname" style="text-align:right;padding-right:5px;padding-left:5px;justify-content: flex-end;">Last Name  : </label>
                                    <input type="text" id="lastname" name="lastname" class="form-control form-control-sm dt-pick" style="width:100px;">
                                  </div>           
                                  
                                  <div class="form-group">
                                    <label for="address" style="text-align:right;padding-right:5px;padding-left:5px;justify-content: flex-end;">Address  : </label>
                                    <input type="text" id="address" name="address" class="form-control form-control-sm dt-pick" style="width:100px;">
                                  </div>           

                                  <div class="form-group">
                                    <label for="email" style="text-align:right;padding-right:5px;padding-left:5px;justify-content: flex-end;">Email  : </label>
                                    <input type="text" id="email" name="email" class="form-control form-control-sm dt-pick" style="width:100px;">
                                  </div>           
                                  &nbsp;&nbsp;&nbsp;                                          
                                  <span class="btn btn-sm btn-primary search-table"><i class="fa fa-search"></i></span>    -->                                 
                              </form>
                      </div>
                          
                  </div>
                  <div style="width:98%;margin: 0 auto;padding-top:10px;">   
                      <!-- <form name="pageForm1" id="pageForm1" action="">   -->
                      <form action="">  
                          <table id="users_tbl" class="table table-striped table-bordered" width="100%">
                                <thead>
                                    <tr>                                          
                                        <!-- <th>ID</th> -->
                                        <th>username</th>
                                        <!-- <th>password</th>
                                        <th>firstname</th>
                                        <th>lastname</th>
                                        <th>phone</th>
                                        <th>email</th>
                                        <th>address</th>
                                        <th>user_type</th>
                                        <th>last_login</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                          </table>
                      </form>
                  </div>
                  <br>
                </div>
              </div>
             
              
            </div>
          </div>
<?php
include('footer.php');
?>
<script>var pathstring = '<?php echo base_url();?>';</script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>nerm.js"></script>
<script type="text/javascript" >
      
$(document).ready(function () {

       // $('.dt-pick').datepicker({
       //      format: 'mm/dd/yyyy',            
       // }); 
       // $(".dt-pick").keydown(false); 
       
       // var brand_name = $("#brand_name").val();
       // var no_commande = $("#no_commande").val();
       
       
       var table_middleware_main = $('#users_tbl').dataTable({
                
                "bLengthChange": false,
                "bFilter": false,
                "bInfo" : false,             
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "pageLength": 50,
                // Load data for the table's content from an Ajax source
                "aoColumns": [
                      null,
                      // null,                 
                      // null,
                      // null,
                      // null,
                      // null,
                      // null,
                      // null,
                      // null,
                      // null   
                 ],
                "ajax": {
                    "url": "<?php echo base_url(); ?>users/ajax_list",
                    "type": "POST",
                    "data": function(d){
                         // d.brand_name = Get_brand_name();
                         // d.no_commande = Get_no_commande();
                         // d.du_date = Get_du_date();
                         // d.au_date = Get_au_date();
                         // d.periode = Get_periode();
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    { 
                        "targets": [ 0 ], //first column / numbering column
                        "orderable": false, //set not orderable                    
                    },
                    // { "sClass": "text-left", "aTargets": [0] },
                    // { "sClass": "text-center", "aTargets": [1] },
                    // { "sClass": "text-center", "aTargets": [2] },
                    // { "sClass": "text-center", "aTargets": [3] },
                    // { "sClass": "text-center", "aTargets": [4] },
                    // { "sClass": "text-center", "aTargets": [5] },
                    // { "sClass": "text-right", "aTargets": [6] },
                    // { "sClass": "text-center", "aTargets": [7] },
                    // { "sClass": "text-center", "aTargets": [8] },
                    // { "sClass": "text-right", "aTargets": [9] }
                ],
                "language": {
                    "sProcessing":     "Traitement en cours...",
                    "sSearch":         "Rechercher&nbsp;:",
                    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix":    "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
                    "oPaginate": {
                        "sFirst":      "Premier",
                        "sPrevious":   "Pr&eacute;c&eacute;dent",
                        "sNext":       "Suivant",
                        "sLast":       "Dernier"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                    },
                    // "select": {
                    //         "rows": {
                    //             _: "%d lignes s�l�ctionn�es",
                    //             0: "Aucune ligne s�l�ctionn�e",
                    //             1: "1 ligne s�l�ctionn�e"
                    //         } 
                    // }
                }
                           
       });
       
       
       // function Get_brand_name(){
       //      return $("#brand_name").val();
       // }
       // function Get_no_commande(){
       //      return $("#no_commande").val();
       // }
       // function Get_periode(){
       //      return $("#periode").val();
       // }
       
       // function Get_du_date(){
       //      return $("#du_date").val();
       // }              
       // function Get_au_date(){
       //      return $("#au_date").val();
       // }
             
       $(".search-table").on("click", function(ev) {        
               refresh_table();         
       });
                        
       function refresh_table(){  
               table_middleware_main.fnDraw();              
       }               
       
       var loc = new locationInfo();
       loc.getBrands();   
                       
          
});
      
</script>
