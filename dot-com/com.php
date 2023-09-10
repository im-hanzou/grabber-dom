<?php
$hijau = "\33[32m";
$kuning = "\033[33m";
$merah = "\033[31m";
$cyan = "\033[36m";
$reset = "\033[0m";
$banner = "
{$hijau}
                            .d$$
                          .' TO$;\
                         /  : TP._;       This tools for scraping domains that are only [dot]com.
                        / _.;  :Tb|       about.me/zaenhxr
                       /   /   ;j$$       
                   _.-\"       d$$$$
                 .' ..       d$$$$;
                /  /P'      d$$$$$. |\
               /   \"      .d$$$$' |\^\"l       
            .'           `T$$^\"\"\"\"\"  :       
         ._.'      _.'                ;          
      `-.-\".-'-. ._.       _.-\"    .-\"
    `.-\" _____  ._              .-\"
   -(.g$$$$$$$$.              .'
     \"\"^^T$$$$^)            .(:
       _/  -\"  /.'         /:/;
    ._.'-'`-'  \")         /;/;
 `-.-\"..--\"   \" /         /  ;
.-\" ..--\"        -'          :
..--\"--.-\"         (\\      .-(\\
  ..--\"              `-\\(\\/;\`
    _.                      : 
                                {$reset}";
echo "$banner\n";
function scraping($start, $until) {
    global $hijau, $cyan, $merah, $kuning, $reset;
    $out_file = fopen('domain.txt', 'w');
    $user_agents = file('user-agent.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    for ($page = $start; $page <= $until; $page++) {
        $url = "https://allthecom.info/com.php?l=25&start={$page}000";
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $random_user_agent = $user_agents[array_rand($user_agents)];
            curl_setopt($ch, CURLOPT_USERAGENT, $random_user_agent);
            $req = curl_exec($ch);
            if(curl_errno($ch)) {
                throw new Exception(curl_error($ch));
            }
            curl_close($ch);
        } catch (Exception $e) {
            echo "[{$merah}ERROR{$reset}] {$e->getMessage()}\n";
            continue;
        }        
        preg_match_all('/<a href=new\/([^\/]+)\/>[^<]+<\/a>/', $req, $regex);
        $total_domains = count($regex[1]);   
        echo "[{$hijau}+{$reset}] Page {$hijau}{$page}{$reset} {$kuning}=>{$reset} Total: {$hijau}{$total_domains}{$reset}\n";
        foreach ($regex[1] as $domain) {
            fwrite($out_file, $domain . "\n");
        }
    }   
    fclose($out_file);
}
$start = readline("Start page: ");
$until = readline("Until page: ");
scraping($start, $until);
