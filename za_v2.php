<?php
$hijau = "\033[32m";
$merah = "\033[31m";
$ungu = "\033[35m";
$cyan = "\033[36m";
$reset = "\033[0m";
$banner = "
   _____           _               
  / ____|         | |              
 | |  __ _ __ __ _| |__   ___ _ __ 
 | | |_ | '__/ _` | '_ \\ / _ \\ '__|
 | |__| | | | (_| | |_) |  __/ |   
  \\_____|_|  \\__,_|_.__/ \\___|_| {$merah}V2.0  
  {$hijau}Auto update persecond. 
  {$ungu}about.me/zaenhxr         
{$reset}";

echo $banner;
function scraping_domain($url, $jumlah_request) {
    global $hijau, $merah, $reset;
    $domain = '/<a href="\/[^\/]*\/" target="_blank">([a-zA-Z0-9-\.]+)<\/a>/';
    $domains = [];
    for ($i = 1; $i <= $jumlah_request; $i++) {
        $response = @file_get_contents($url);
        if ($response === false) {
            echo "[{$merah}-{$reset}] Gagal mengambil data dari {$merah}{$url}{$reset}\n";
            continue;
        }
        preg_match_all($domain, $response, $domain_regex);
        $domains = array_merge($domains, $domain_regex[1]);
        echo "[{$hijau}+{$reset}] Request {$hijau}{$i}{$reset}: Total {$hijau}" . count($domain_regex[1]) . "{$reset}\n";
        sleep(2);
    }
    return $domains;
}
function main() {
    global $hijau, $merah, $cyan, $reset;
    $url = 'https://ipchaxun.com/';
    echo "{$cyan}Jumlah request: {$reset}";
    $jumlah_request = intval(trim(fgets(STDIN)));
    $domains = scraping_domain($url, $jumlah_request);
    $out_file = fopen('result.txt', 'w');
    fwrite($out_file, implode("\n", $domains));
    fclose($out_file);
    $result = file_get_contents('result.txt');
    $ip = '/((?:\d{1,3}\.){3}\d{1,3})/';
    preg_match_all($ip, $result, $ip_regex);
    $ip_file = fopen('ip.txt', 'w');
    fwrite($ip_file, implode("\n", $ip_regex[0]));
    fclose($ip_file);
    $domain_regex_final = '/\b(?:https?:\/\/)?(?:www\.)?\S+\.\S+\b/i';
    preg_match_all($domain_regex_final, $result, $domain_regex);
    $domain_file = fopen('domain.txt', 'w');
    fwrite($domain_file, implode("\n", $domain_regex[0]));
    fclose($domain_file);
    echo "[{$hijau}+{$reset}] Total Domain: {$cyan}" . count($domain_regex[0]) . "{$reset}\n";
    echo "[{$hijau}+{$reset}] Total IP: {$cyan}" . count($ip_regex[0]) . "{$reset}\n";
    unlink('result.txt');
}
main();
?>
