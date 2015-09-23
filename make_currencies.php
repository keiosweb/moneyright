<?php

echo "Creating currencies.php file.";

function loadJson($path)
{
    return json_decode(file_get_contents($path), true);
}

function exportArray(array $currencies)
{
    return file_put_contents(__DIR__.'/src/config/currencies.php', '<?php'.PHP_EOL.'return '.var_export($currencies, true).';');
}

$iso = loadJson(__DIR__.'/src/config/currency_iso.json');
$nonIso = loadJson(__DIR__.'/src/config/currency_non_iso.json');

$merged = array_merge($iso, $nonIso);

return exportArray($merged);