## About test APP  
  
This is a test application done for **2MD** company done as test task during the recruitment process.  
The application is created using **PHP Symfony Framework** and contains two console commands:  
 1. Command to count a number of occurrences "John" and "Mary" in an input text. It returns "1" if the numbers are the same, otherwise returns "0".  The command is looking only for whole words.
 2.  Command to sort JSON products array by price and title ascending. The command returns a sorted array in JSON format.  
  
## Installation  
 1. Clone the git repository  
 2. Go to application directory and install it using composer command: `composer install`. You can also test if your system checks the application requirements before installation using the command:  `composer check-platform-reqs`

  
## How to run it?  

 1. The first command you can run like this: 
 `php bin/console text:search-names <text>` 
 where **\<text\>** argument  is a string containing "John" or "Mary" names. As an output, you can see 1 if numbers of occurrences are equal or 0 in otherwise.  There is physically at the path **src/Command/SearchTextCommand.php**
 2. The second command run: 
  `php bin/console products:sort <products>`
    where **\<products\>**  argument must be a JSON string containing an array of products with titles and prices fields. The command returns a JSON with sorted products by price and title ascending. There is physically at the path **src/Command/SortProductsCommand.php**

  
## Tests  
  
To run unit tests just run the command:  

    php bin/phpunit

