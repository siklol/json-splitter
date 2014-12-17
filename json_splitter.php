<?php
/**
 * Usage: php json_splitter.php "/path/to/json/file.json" TestDataElements 50
 * User: Veit Osiander
 * Date: 12/17/14
 * Time: 10:06 AM
 */
if (empty($argv[1])) {
    throw new \Exception("Please provide a valid path to a json file");
}
if (!is_file($argv[1])) {
    throw new \Exception("Please provide a valid path to a json file");
}
if (empty($argv[2])) {
    throw new \Exception("Please provide a split argument");
}

$chunkNumber = !empty($argv[3]) ? $argv[3] : 100;
$original = json_decode(file_get_contents($argv[1]), true);

$base = $original;
if (empty($base[$argv[2]])) {
    throw new \Exception("Path argument {$argv[2]} does not exist!");
}

unset($base[$argv[2]]);

$partNum = 0;
while (!empty($original[$argv[2]])) {
    $part = $base;
    for ($i=0; $i<$chunkNumber; $i++) {
        $part[$argv[2]][] = array_shift($original[$argv[2]]);
    }

    file_put_contents($argv[1].'.part'.$partNum.'.json', json_encode($part));
    $partNum++;
    echo "Part {$partNum} saved!\n";
}
