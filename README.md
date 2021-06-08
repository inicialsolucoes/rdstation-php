# RD Station API Integration (PHP)

[![Packagist](https://img.shields.io/packagist/v/inicial/rdstation-php.svg?style=flat-square)](https://packagist.org/packages/inicial/rdstation-php)
[![License](https://img.shields.io/badge/license-RD%20Station%20PHP-blue.svg?style=flat-square)](https://github.com/inicialsolucoes/rdstation-php/blob/master/LICENSE)

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

$ composer require inicial/rdstation-php

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
