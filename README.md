# URL Shortener for PHP

## How to Use

### Install Packages

#### Ubuntu
\# `apt-get install php5-fpm php5-mysqlnd php-pear php5-dev`
\# `pacl install runkit`

### Web Server Config

#### NGINX
```Example.conf
server{
  listen    80;
  #listen    443 ssl; #http2(or spdy);
  root      example.com;
  index     index.php;
  charset   utf-8;
  try_files $uri $uri/ =404 @urlshortener;
  location  ~ \.php$ {
    try_files $uri @urlshortener;
    fastcgi_param  SCRIPT_FILENAME $docment_root$script_file_name;

    ## More Options
  }
  location  = @urlshortener {
    fastcgi_param  SCRIPT_FILENAME $docment_root/<urlshortener dir/>index.php;

    ## More Options
  }
}
```

