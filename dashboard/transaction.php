<?php
session_start();

 require '../guard.php';
require_once '../classes/Expense.php';
require_once '../classes/Paginate.php';


$userId = $_SESSION['is_logged_in'];

$s = new Expense;

$totalRecord = $s->getTotalRecords();

$paginator = new Paginator($_GET['page'] ?? 1, 6, $totalRecord);

$transactions = $s->getTransactions( $paginator->limit, $paginator->offset);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    
    <!-- Bootstrap CSS -->
    <!-- Style CSS -->
     <?php require 'dp_partials/head_nav.php';  ?>

    <!-- end nav -->

         <div class="container-fluid">
        <div class="container-fluid" >

             <div class="row mx-4 py-4">

                <div class="col-md-8 mb-3">
                     <form  method="post" class=""> 
                    
        <div class="row">
          <div class="col">
            <label for="expenseDate_start" class="form-label">From: </label>
            <input type="date" name="expenseDate_start" id="expenseDate_start" value="<?= date('Y-m-d'); ?>"  class="form-control" placeholder="Start date" aria-label="Start date">
          </div>
          <div class="col">
            <label for="expenseDate_end" class="form-label">To: </label>
            <input type="date" name="expenseDate_end" id="expenseDate_end" value="<?= date('Y-m-d'); ?>"  class="form-control" placeholder="End date" aria-label="End date">
          </div>
        </div>
        <div class="col-12">
        <div class="input-group ">
          <label class="input-group-text btn btn-info" for="inputGroupSelect01">Search</label>
                <input type="search" name="searchkey" id="searchkey" placeholder="search through expense" class="form-control">
        </div>
        </div>
         
</form>
              <!--  <input type="search" name="searchkey" id="searchkey" placeholder="search through expense" class="">
               <button  name="btn" class="" id="btnsearch">Search</button>
                </form> -->

            </div>
           
             </div>


            <div class="container-fluid ">
                <div class="row">
              
                <div class="col-md-12">
                   
                    <div class="table-container">

                        <div class="container" id="searcher">
                            <div class="row">
                                <div class="col-md-12" id="searcharray">
                                    
                                </div>
                            </div>
                        </div>
                        
                          <table class="table table-bordered stripe table-hover table-md" id="searchbody">
                             
                            <thead>
                                <tr>
                                                                        
                                     <th scope="col">Description</th>
                                    <th scope="col">ِAmount</th>
                                   
                                    <th scope="col">Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody id="">
                        
                    <?php 
                        if (count($transactions) > 0) {
                            foreach($transactions as $transaction) { ?>
                                <tr>
                               
                               <td><?= ucwords($transaction['memo'] ) ?></td>
                                <td> <?php if($transaction['amount'] > 2000)  { ?>
                                    <span class="badge text-bg-success">₦ <?=$transaction['amount'] ?></span> 
                             <?php } else { ?>
                                    <span class="badge text-bg-info">₦ <?=$transaction['amount'] ?></span> 
                             <?php } ?>

                                </td>

                                <td>
                              <?php if($transaction['transaction_type'] == 'income') { ?>
                                <span class="badge text-bg-success">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
      
                             <?php }elseif($transaction['transaction_type'] == 'transfer'){ ?>
                                    <span class="badge text-bg-danger">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
                            <?php }else{ ?>
                                     <span class="badge text-bg-info">
                                    <?=$transaction['transaction_type'] ?>  
                                  </span>
                            <?php } ?>
                        
                                  </td>
                                  <td> <span class="badge text-bg-dark"><?=$transaction['date_incurred'] ?></span> </td>
                
                                  <td class="text-center d-flex">
                                        
                                 <form action="db_process/delete_transaction.php" method="get">
                                    <button class="btn btn-warning" type="submit" name="btn">
                                    <i class="fas fa-trash"></i> 
                                    <a class="btn btn-sm" href="db_process/delete_transaction.php?catid=<?=$transaction['transaction_id'] ?>" name ='delete'>Delete Category</a>

                                  </button>
                                 </form>
                                      
                                    </td>
                                </tr>

                       <?php 
                        } ?> 
                    <?php } else {
                            echo "<tr><td colspan = '4'> Oopsies! You haven\'nt create any expense yet. <a href='add_expense.php' class='btn btn-secondary'>Click here to create one</a> </td></tr>";
                       } ?>

                            </tbody>
                        </table>
                        </table>

                    </div>
                </div>

                <?php require 'dp_partials/paginator.php'; ?>
           

                </div>
            </div>

        </div>
    </div>



       <script src="../bootstrap/js/bootstrap.bundle.js"> </script>
    <!-- Script JS -->
    <script src="./script.js"></script>
     <script src="../assets/jquery/jquery.min.js"></script>

    <script>

        $(document).ready(function(){

       $("#searchkey").keyup(function(){
        event.preventDefault();


        let btnsearch = $('#btnsearch').val();
        let searchkey = $('#searchkey').val();
        let start_date = $('#expenseDate_start').val();
        let end_date =  $('#expenseDate_end').val();

         var search_data = {
            btnsearch,
            searchkey,
    
            start_date, 
            end_date,
            btn : true
            };

        
            
        //ajax
        $.ajax({
            url : "db_process/search_ajax.php",
            type : "post",
            data : search_data,
            dataType : "text",
            success : function(data){
                console.log(data);
                if (searchkey !== '') {
                  let body = $('#searchbody').hide();
                  let pag = $('#paginator').hide();
                  let categories = $('#searcharray').html(data); 
               
                    } else{
                let categories = $('#searcharray').html('');
                let body = $('#searchbody').show();
                let pag = $('#paginator').show();
               }
                
            },
            error : function(error) {
                console.log(error);
             } 
        });
            
    });


        })

    </script>
</body>
</html>

