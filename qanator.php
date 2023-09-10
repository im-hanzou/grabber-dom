<?php
$hijau = "\33[32m";
$kuning = "\33[33m";
$merah = "\33[31m";
$reset = "\33[0m";
$banner = "{$hijau}    
    ____              ___   __            
   / __ \____ _____  /   | / /_____  _____
  / / / / __ `/ __ \/ /| |/ __/ __ \/ ___/
 / /_/ / /_/ / / / / ___ / /_/ /_/ / /    
 \___\_\__,_/_/ /_/_/  |_\__/\____/_/ 
                    {$kuning}about.me/zaenhxr{$reset}
{$merah}[{$reset}based on requests and auto filter duplicates{$merah}]{$reset}\n\n";                                       
echo $banner;                                        
function scraping($url)
{
    global $hijau, $kuning, $merah, $reset;
    $req = file_get_contents($url);
    $regex = '/<li class="ct"><a href="http:\/\/(.*?)\.qanator\.com" >.*?<\/a><\/li>/';
    preg_match_all($regex, $req, $pattern);
    return $pattern[1];
}
$req_jumlah = readline("Jumlah request: ");
if (empty($req_jumlah)) {
    echo "[{$merah}-{$reset}] {$merah}Input kosong !{$reset}\n";
} else {
    $url = "http://qanator.com/";
    $all_domain = [];
    $file = fopen("{$req_jumlah}-domain.txt", "w");
    for ($i = 1; $i <= $req_jumlah; $i++) {        
        sleep(2);
        $domains = scraping($url);
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
