<?php
$memcache = new Memcached();
$memcache->addServer('memcached', 11211);

// Test zapisu i odczytu
$memcache->set('test_key', 'test_value', 60);
$value = $memcache->get('test_key');

if ($value === 'test_value') {
    echo "Memcached działa poprawnie!";
} else {
    echo "Błąd: Nie można połączyć się z Memcached.";
}
?>
