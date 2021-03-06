CalveraPaymentSecurionBundle
========================

A Symfony2 Bundle that provides access to the Securion API. Based on JMSPaymentCoreBundle.

## Installation

### Step1: Require the package with Composer

````
php composer.phar require symfony/event-dispatcher:^2.8
php composer.phar require calvera/payment-securion-bundle
````

### Step2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Calvera\Payment\SecurionBundle\CalveraPaymentSecurionBundle(),
    );
}
```

### Step3: Configure

Add the following to your config.yml:
```yaml
calvera_payment_securion:
    api_key:  Your API key
    logger:   true/false   # Default true
    methods:
      - checkout
```

Make sure you set the `description` in the `predefined_data` for every payment method you enable:
````php
$form = $this->getFormFactory()->create('jms_choose_payment_method', null, array(
    'amount'   => $order->getAmount(),
    'currency' => 'EUR',
    'predefined_data' => array(
        'securion_checkout' => array(
            'description' => 'My product',
        ),
    ),
));
````

See [JMSPaymentCoreBundle documentation](http://jmsyst.com/bundles/JMSPaymentCoreBundle/master/usage) for more info.
