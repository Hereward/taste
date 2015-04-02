Recipe Builder Notes

Code has been deployed and can be accessed here:
http://taste.planetonline.com.au

Work is 100% my own and is built on a lightweight MVC framework which is also my own creation.

There are 2 models:
Recipe_model
Ingredients_model

There is one main Controller:
Search_controller

I have provided some phpUnit tests in the Test folder. The tests do not provide 100% coverage - I don't have the time to develop a full test suite.

The app does not include error trapping for malformed input - this was not in the brief.

Basic logic flow:

1. Read and parse CSV and JSON data.
2. Identify and remove expired items from the ingredients inventory
3. Prepare a list of viable recipes from the recipes data, matched with available ingredients.
4. Determine the relative "freshness" of each potential recipe by comparing the "longevity" of the ingredients in each recipe, then sorting this list in descending order.
5. The first recipe in the sorted list from (5) becomes the recommended meal. 

Copyright Eye of the Tiger - All rights reserved.




