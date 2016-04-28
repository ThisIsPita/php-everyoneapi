# php-everyoneapi

PHP Library for EveryoneAPI (everyoneapi.com)

## Example

```php
//include everyoneAPI library.
require_once("everyoneapi.php");

//create everyoneAPI object.
$obj = new everyoneAPI("[account_sid]", "[auth_token]");

//get all data points.
$data = $obj->getData("5551234567");

//get one data point.
$data = $obj->getData("5551234567", "cnam");

//get multiple data points.
$data = $obj->getData("5551234567", "cnam,line_provider,linetype");
```
For more information view the [EveryoneAPI documentation](https://www.everyoneapi.com/docs)