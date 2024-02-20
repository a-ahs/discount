<?php

    namespace App\Services\Notification;

    use App\Services\Notification\Contract\Provider;

    class Notification
    {
        public function __call($method, $arguments)
        {
            $providerPath = __NAMESPACE__ . '\Providers\\' . substr($method, 4) . 'Provider';
            if(!class_exists($providerPath))
            {
                throw new \Exception('Class Doesnt Exist');
            }

            $providerInstace = new $providerPath(...$arguments);
            if(!$providerInstace instanceof Provider)
            {
                throw new \Exception('Provider doesnt Exist');
            }

            $providerInstace->send();

            // dd($providerPath);
        }
    }

?>