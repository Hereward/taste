
<div class="jumbotron">
    <div class="container">
        <h1>Search Results</h1>
       
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12"><h2 style="text-align:center;margin:0px auto;">The chef recommends: <strong><?=$data['recommendation']?></strong></h2></div>   
    </div>
    <hr>
    <h4>System Messages</h4>
    <div class="row">
        <div style="margin:20px 20px 0px 0px;" class="col-lg-12">
            
           <?php foreach ($data['ingredients_messages'] as $msg) { ?>
            <div class="alert alert-danger"><?=$msg?></div>
           <?php } ?>
            
           <?php foreach ($data['recipe_messages'] as $msg) { ?>
            <div class="alert alert-danger"><?=$msg?></div>
           <?php } ?>
            
            
      
        </div>
    </div>


</div>