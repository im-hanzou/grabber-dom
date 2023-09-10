<?php
$hijau = "\33[32m";
$kuning = "\33[33m";
$merah = "\33[31m";
$cyan = "\33[36m";
$reset = "\33[0m";
$banner = "
{$cyan}*******************************************
{$hijau}Grab domain per page {$kuning}[{$reset}{$merah}top domain{$reset}{$kuning}]{$reset}
       {$hijau}Coded by Zaen
        about.me/zaenhxr 
{$cyan}*******************************************{$reset}\n\n";
echo $banner;
function scrap_topdomain($page)
{
    global $hijau, $kuning, $merah, $cyan, $reset;
    $url = "https://www.hupso.com/top/" . $page;
    $req = file_get_contents($url);
    $regex = '/<a href="https:\/\/www\.hupso\.com\/www\/([^"]+)">/';
    preg_match_all($regex, $req, $pattern);
    $domains = $pattern[1];
    $total = count($domains);
    echo "[{$hijau}+{$reset}] Page {$hijau}$page{$reset} {$kuning}=>{$reset} Total: {$hijau}$total{$reset}\n";
    return $domains;
}
$start = readline("Start page: ");
$until = readline("Until page: ");
if (empty($start) || empty($until)) {
    echo "[{$merah}-{$reset}] {$merah}Empty input !{$reset}\n";
    exit;
}
$all_domains = array();
for ($page = $start; $page <= $until; $page++) {
    $page_domains = scrap_topdomain($page);
    $all_domains = array_merge($all_domains, $page_domains);
}
$filter_domains = array_unique($all_domains);
$out_file = fopen("top_domain.txt", "a");
foreach ($filter_domains as $domain) {
    fwrite($out_file, $domain . "\n");
}
fclose($out_file);
