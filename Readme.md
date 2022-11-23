Documentation for shop APIs.

Environment used:
PHP Version 7.4.11
MySQL Version: 8.0.29
Xampp WebServer with Apache
**---Setup Steps**

1)Firstly clone the git repo to the relevant folder you will use the server.
For example Xampp uses htdocs as root folder for server

2)Import the dump files to create the databases

3)Change inside defines.php file the relevant information for database connectivity.

4)Change inside the tokenDefines.php file the relevant information for the path for tokenGenerator and tokenValidation scripts


**---ShopApis Information:**

1)Registration  API
Call the API by using POST to the registration.php script

The api that is used to register.
If everything goes well a success message is given.

2)Login API
Call the API by using POST to the registration.php script

The API is used to login.
If everything goes well a token will be returned that will be valid for 1 hour.

3)Create shop API
Call the API by using POST to the createShop.php script

The api that is used to create one shop each call.
Use the token from login for the procedure

4)Delete shop API
Call the API by using DELETE to the deleteShop.php script

The api that is used to delete one shop each call.
Use the token from login for the procedure

5)Edit Shop API
Call the API by using PUT to the editShop.php script

The api that is used to edit one shop each call.

Many columns can be edited at one call.
Use the token from login for the procedure

Note: For the category I consider that the new category already exists in shop_categories table


6)Show Shop API
Call the API by using GET to the showShop.php script

The api that is used to show shops.

The usage of token considers the call is made by an owner logged in,
if no token is used the call is made by a guest.

Each of the above APIs have an example as comment on top of the code of a json that can be used to make the call.


**---Internal APIs**
1)Token Generator API
An API that is used internally from the project to generate and write the token information to the database

2)Token Validation API
An API that is used internally from the project to validate if the token is correct and still active.
