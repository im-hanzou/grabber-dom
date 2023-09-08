<?php
$hijau = "\33[32m";
$kuning = "\033[33m";
$merah = "\033[31m";
$cyan = "\033[36m";
$reset = "\033[0m";
$banner = "
{$cyan}*******************************************
        {$hijau}Grab domain per page
            Coded by Zaen
         about.me/zaenhxr
{$cyan}******************************************{$reset}";
echo "$banner\n";
function scraping($from_page, $to_page) {
    global $hijau, $cyan, $merah, $kuning, $reset;
    $out_file = fopen('page-domain.txt', 'w');
    for ($page = $from_page; $page <= $to_page; $page++) {
        $url = "https://www.dubdomain.com/index.php?page={$page}";
        $req = file_get_contents($url);
        preg_match_all('/<a href="q\.php\?domain=([^"]+)" title="[^"]+">[^<]+<\/a>/', $req, $regex);
        $total_domains = count($regex[1]);
        echo "[{$merah}+{$reset}] Page {$hijau}{$page}{$reset} {$kuning}=>{$reset} Total: {$hijau}{$total_domains}{$reset}\n";
        foreach ($regex[1] as $domain) {
            fwrite($out_file, $domain . "\n");
        }
    }   
    fclose($out_file);
}
$from_page = readline("From page: ");
$to_page = readline("To page: ");
scraping($from_page, $to_page);
