<?php 
$categories = [
    "Diary and Notebook",
    "অন্ধকার থেকে আলোতে",
    "আত্ম-উন্নয়ন ও মোটিভেশন",
    "আত্মজীবনী",
    "আদব আখলাক",
    "আধ্যাত্মিকতা ও সুফিবাদ",
    "আরবি ভাষা শিক্ষা",
    "আল হাদিস",
    "আল-কুরআন",
    "আল-হাদিস",
    "ইতিহাস ও ঐতিহ্য",
    "ইবাদাত আত্মশুদ্ধি ও অনুপ্রেরণা",
    "ইংরেজি ব্যাকরণ ও ভাষা শিক্ষা",
    "ইসলাম ও নারী",
    "ইসলাম ও সমকালীন বিশ্ব",
    "ইসলাম প্রসঙ্গ",
    "ইসলামি : ইতিহাস ও ঐতিহ্য",
    "ইসলামি : বিবিধ বই",
    "ইসলামি আদর্শ ও মতবাদ",
    "ইসলামি গবেষণা",
    "ইসলামি জ্ঞান চর্চা",
    "ইসলামি দর্শন",
    "ইসলামি বিধি বিধান ও মাআলা মাসায়েল",
    "ইসলামি ব্যক্তিত্ব",
    "ইসলামি ম্যাগাজিন",
    "ইসলামি শাসনব্যবস্থা ও রাজনীতি",
    "ইসলামি সাহিত্য, গল্প-উপন্যাস",
    "ইসলামী চিকিৎসা",
    "ঈমান আক্বিদা ও বিশ্বাস",
    "উদ্যোক্তা",
    "ঐতিহাসিক ব্যক্তিত্ব",
    "কবিতা",
    "কিয়ামতের আলামত",
    "কুরআন বিষয়ক আলোচনা",
    "কুরআনের তরজমা ও তাফসীর",
    "গোয়েন্দা ও গোপন সংস্থা",
    "জেনারেল বুকস",
    "তাজউইদ",
    "থ্রীলার",
    "দাওয়াহ ও আলোচনা",
    "দাম্পত্য জীবন",
    "নওমুসলিমদের জন্য",
    "নবী-রাসূল ও সাহাবীদের জীবনী",
    "নামায, দুআ-দরুদ ও যিকির",
    "নোটবুক",
    "পরকাল ও জান্নাত-জাহান্নাম",
    "পরিবার ও শিশু বিষয়ক (প্যারেন্টিং)",
    "প্রবন্ধ",
    "ফিকশন",
    "ফিকাহ ও ফতওয়া",
    "বক্তৃতা",
    "বয়ান সংকলন",
    "বাংলা ভাষা ও সাহিত্য",
    "বিদয়াত ও কুসংস্কার",
    "বিবিধ বই",
    "বিয়ে",
    "বিশ্ব রাজনীতি",
    "বুকমার্ক",
    "ব্যক্তি, পরিবার ও সামাজিক জীবন",
    "ব্যবসা-বিনিয়োগ ও অর্থনীতি",
    "ব্যবস্থাপনা ও নেতৃত্ব",
    "ভ্রমণ",
    "মন ও মানসিক কাউন্সেলিং",
    "মাইক্রোসফট অফিস",
    "যাকাত ও ফিতরা",
    "যুদ্ধবিগ্রহ ও গণহত্যা",
    "রাজনৈতিক দ্বন্দ্ব",
    "শিশু কিশোরদের বই",
    "সন্তান প্রতিপালন",
    "সমসাময়িক উপন্যাস",
    "সিয়াম, রমযান, তারাবীহ ও ঈদ",
    "সীরাতে রাসূল ﷺ",
    "সুন্নাত ও শিষ্টাচার",
    "স্টিকার, কার্ড",
    "স্বপ্ন ও স্বপ্নের ব্যাখ্যা",
    "হজ্জ-উমরাহ ও কোরবানি",
    "হাদিস বিষয়ক আলোচনা",
    "হালাল হারাম"
];

?>

server {
    listen 80;
    listen [::]:80;
    server_name vapehub.co.uk;
    return 301 https://www.vapehub.co.uk$request_uri;
}

 server {
     listen 443 ssl http2;
     listen [::]:443 ssl http2;
     ssl_certificate /etc/letsencrypt/live/vapehub.co.uk/fullchain.pem;
     ssl_certificate_key /etc/letsencrypt/live/vapehub.co.uk/privkey.pem;
     server_name www.vapehub.co.uk;
     return 301 https://www.vapehub.co.uk$request_uri;
 }

server {
    listen 80;
    listen [::]:80;
    server_name www.vapehub.co.uk;
    return 301 https://www.vapehub.co.uk$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    ssl_certificate /etc/letsencrypt/live/vapehub.co.uk/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/vapehub.co.uk/privkey.pem;
    root /var/www/vapehub;
    index index.php index.html index.htm;
    #BEGIN Converter for Media
    set $ext_avif ".avif";
    if ($http_accept !~* "image/avif") {
        set $ext_avif "";
    }

    set $ext_webp ".webp";
    if ($http_accept !~* "image/webp") {
        set $ext_webp "";
    }

    location ~ /wp-content/(?<path>.+)\.(?<ext>jpe?g|png|gif|webp)$ {
        add_header Vary Accept;
        expires 365d;
        try_files
            /wp-content/uploads-webpc/$path.$ext$ext_avif
            /wp-content/uploads-webpc/$path.$ext$ext_webp
            $uri =404;
    }
    # END Converter for Media
    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }
    location ~ \.php$ {
        fastcgi_read_timeout 300;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
    location ~ /.well-known {
        allow all;
    }
}