<?php
$hijau = "\33[32m";
$kuning = "\33[33m";
$merah = "\33[31m";
$reset = "\33[0m";
$banner = "{$hijau}                                                                
  _                _                         _     _                           
_| |___ _____ __ _|_|___ ___ ___ ___ ___ ___|_|___| |_ ___ ___   ___ ___ _____ 
| . | . |     | .'| |   |_ -|___|  _| -_| . | |_ -|  _| -_|  _|_|  _| . |     |
|___|___|_|_|_|__,|_|_|_|___|   |_| |___|_  |_|___|_| |___|_| |_|___|___|_|_|_|
                                        |___| {$kuning}Coded by Zaen{$reset}";                                       
echo "$banner\n";                                        
function domain_register($url)
{
    global $hijau, $kuning, $merah, $reset;
    $req = file_get_contents($url);
    $regex = "/<a href='\/([^']+)' title='[^']+'>[^<]+<\/a>/";
    preg_match_all($regex, $req, $pattern);
    return $pattern[1];
}
$req_jumlah = readline("Jumlah request: ");
if (empty($req_jumlah)) {
    echo "[{$merah}-{$reset}] {$merah}Input kosong !{$reset}\n";
} else {
    $url = "http://domains-register.com/";
    $all_domain = [];
    $file = fopen("{$req_jumlah}-domain.txt", "w");
    for ($i = 1; $i <= $req_jumlah; $i++) {        
        sleep(2);
        $domains = domain_register($url);
        $total_domain = count($domains);
        echo "[{$hijau}+{$reset}] Request {$hijau}$i{$reset} => Found: [{$hijau}$total_domain{$reset}] domain\n";
        $total_domain = array_merge($all_domain, $domains);
        foreach ($domains as $domain) {
            fwrite($file, $domain . "\n");
        }
    }
    $filter_domain = array_unique($all_domain);
    foreach ($filter_domain as $domain) {
        fwrite($file, $domain . "\n");
    }
    fclose($file);
}
