<div class="jumbotron">
    <div class="container">
        <h1>Recipe Builder</h1>
        <p>This is a web application for building recipes.</p>
    </div>
</div>

<div style="margin:0px auto; max-width:500px;">
    <form action="search" method="post"  role="form">
               
  <div class="form-group">
    <label for="recipes">Recipes JSON</label>
    <textarea name="recipes" id="recipes" class="form-control" rows="10">
[{
        "name": "grilled cheese on toast",
        "ingredients": [
            {
                "item": "bread",
                "amount": "2",
                "unit": "slices"
            },
            {
                "item": "cheese",
                "amount": "5",
                "unit": "slices"
            }
        ]
    }
    ,
    {
        "name": "salad sandwich",
        "ingredients": [
            {
                "item": "bread",
                "amount": "2",
                "unit": "slices"
            },
            {
                "item": "mixed salad",
                "amount": "200",
                "unit": "grams"
            }
        ]
    }]


    </textarea>
  </div>
     
        <div class="form-group">
            <label for="ingredients">Ingredients CSV</label>
            <textarea name="ingredients" id="ingredients" class="form-control" rows="10">
bread,10,slices,3/4/2015
cheese,10,slices,25/12/2015
butter,250,grams,25/12/2015
peanut butter,250,grams,2/12/2013
mixed salad,500,grams,26/12/2015
            </textarea>
        </div>
        

  <button type="submit" class="btn btn-default pull-right">Submit</button>
  <div class="clearfix"></div>
</form>
    
</div>