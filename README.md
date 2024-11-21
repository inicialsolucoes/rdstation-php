# RD Station API Integration (PHP)

[![Latest Stable Version](https://poser.pugx.org/inicial/rdstation-php/v)](https://packagist.org/packages/inicial/rdstation-php) [![Total Downloads](https://poser.pugx.org/inicial/rdstation-php/downloads)](https://packagist.org/packages/inicial/rdstation-php) [![Latest Unstable Version](https://poser.pugx.org/inicial/rdstation-php/v/unstable)](https://packagist.org/packages/inicial/rdstation-php) [![License](https://poser.pugx.org/inicial/rdstation-php/license)](https://packagist.org/packages/inicial/rdstation-php) [![PHP Version Require](https://poser.pugx.org/inicial/rdstation-php/require/php)](https://packagist.org/packages/inicial/rdstation-php)

### Description

Integration class to create and update leads on RD Station.

### With this class you can

- Send a new lead/conversion
- Update lead
- Send lead tags
- Update lead stage
- Update lead status

### Depencies

- Web server with PHP support
- PHP extension CURL enabled

### Composer

```shell
$ composer require inicial/rdstation-php
```
### Usage

```php
<?php
require_once(dirname(__FILE__) . '/init.php');

$rdStation = new \RDStation\RDStation('LEAD_EMAIL');
$rdStation->setApiToken('RD_TOKEN');
$rdStation->setLeadData('identifier', 'event-identifier');
$rdStation->setLeadData('name', 'Fabiano Couto');

// You can set all RD Station default fields and add custom fields as you want
// Read more about on http://ajuda.rdstation.com.br/hc/pt-br
// After setup all data, just call a method to make request to RD Station API

// Send a new lead/conversion
$rdStation->sendLead();
?>
```

### Note

You can find more info about usage on class source code.

Report any bug or suggest changes using git [issues](https://github.com/inicialsolucoes/rdstation-php/issues).
