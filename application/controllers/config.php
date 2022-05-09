<?php 
require(dirname(__FILE__)."/stripe-php-master/init.php");

$publishablekey = "pk_test_51IlXo6G5BhKeRDfTt4yjqM7zHGP0q14Ma2qOBMxYAKx2EX5gLCVZiQpb4ZZMcP69BVJEkIsAMATDyhJLYjSR0DrQ005jD3T6fw";
$secretkey = "sk_test_51IlXo6G5BhKeRDfTmCYLpZjnDUjIECIgBZUlFNzYGQqXepWsBCxj6lVHrBWAm4iYNUbvABO7jEpcgf8VEsGp6K0G00X9HlI94e";

\Stripe\Stripe::setApiKey($secretkey);

?>