<?php
    $banner = "                                                
     ____           _     _               
    / ___|_ __ __ _| |__ | |__   ___ _ __ 
   | |  _| '__/ _` | '_ \| '_ \ / _ \ '__|
   | |_| | | | (_| | |_) | |_) |  __/ |   
    \____|_|  \__,_|_.__/|_.__/ \___|_|   
                        Coded by Zaen";
    echo "\033[31m" . $banner . "\033[0m\n";
function grabber()
{
    $url = "https://urlscan.io/json/live/";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    $replace = [
        "google.com",
        "bing.com",
        "yahoo.com",
        "microsoft.com",
        "github.com",
        "facebook.com",
        "instagram.com",
        "whatsapp.com",
        "wordpress.com", 
        "blogger.com", 
        "medium.com", 
        "storage.googleapis.com", 
        "twitter.com", 
        "googleusercontent.com", 
        "cloudflare.com", 
        "amazon.com", 
        "bit.ly"
    ];
    $domain = '';
    $ip = '';
    $ress = '';
    foreach ($data['results'] as $result) {
        $domain = $result['task']['domain'];
        $ip = $result['page']['ip'];
        if (!in_array($domain, $replace)) {
            $file_domain = fopen("domain.txt", "a+");
            fwrite($file_domain, $domain . "\n");
            fclose($file_domain);

            $file_ip = fopen("ip.txt", "a+");
            fwrite($file_ip, $ip . "\n");
            fclose($file_ip);    
            $ress .= "[+] Domain:" . "\033[32m" . $domain . "\033[0m" . " | IP:" . "\033[32m" . $ip . "\033[0m\n";
        }
    }
    echo "\033[137m" . $ress . "\033[0m\n";
}
function main()
{
    sleep(1);
    echo "Jumlah request: ";
    $request = intval(trim(fgets(STDIN)));
    for ($i = 1; $i <= $request; $i++) {    
        grabber();
       sleep(3); 
    }
}
main();
