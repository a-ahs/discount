<?php

    namespace App\Support\Storage;

use App\Support\Storage\Contract\StorageInterface;
use Countable;

    class SessionStorage implements StorageInterface, Countable
    {
        public function __construct(private $bucket = 'default')
        {
        }
        
        public function set($index, $value)
        {
            return session()->put($this->bucket . '.' . $index, $value);
        }

        public function get($index)
        {
            return session()->get($this->bucket . '.' . $index);
        }

        public function unset($index)
        {
            return session()->forget($this->bucket . '.' . $index);
        }

        public function exist($index)
        {
            return session()->has($this->bucket . '.' . $index);
        }

        public function all()
        {
            return session()->get($this->bucket) ?? [];
        }

        public function clear()
        {
            return session()->forget($this->bucket);
        }

        public function count(): int
        {
            return count($this->all());
        }
    }

?>