<article>
  <h1>How to Use</h1>
  <section>
    <h1>url scheme</h1>
    <pre><code><?php
      echo $urlscheme;
    ?></code></pre>
  </section>
  
  <section>
    <h1>on php</h1>
    <pre><code>get-shorturl.php
&lt;?php
  $param = array(
    'url'    => $url,
    'short'  => $short,
    'uid'    => $apiuid,
    'key'    => $apikey,
    'title'  => $title,
    'format' => $format,
    'type'   => $type
    );
  $param = http_build_query($param, "", "&");
  $header = array(
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: " . strlen($param)
    );
  $context = array(
    "http"    => array(
      "method"  => "POST"
      "header"  => implode("\r\n", $header),
      "content" => $param
      )
    );
  $context = stream_context_create($context);
  $url = "<?php echo $url; ?>";
  $contents = file_get_contents($url, false, $context);
  echo $contents;
?&gt;
    </code></pre>
  </section>
  <section>
    <h1>Post & Get Methods</h1>
    <ul>
      <li>$url = you want to short url(1)</li>
      <li>$short = <?php echo scheme . '://' . urlsdomain . '/'; ?>"here(unique)"</li>
      <li>$title = linkname(2)</li>
      <li>$apiuid = API's User ID</li>
      <li>$apikey = API Key</li>
      <li>$format = return fotmat(3)</li>
      <li>$type = return type(4)</li>
    </ul>
    <ol>
      <li>Blank NG.</li>
      <li>Disable when API Not Fill.</li>
      <li>Blank is Full. Patterns is "long_and_short"/'longurl and shorturl', "short_only"/'only shorturl', "url"/'$type = `txt`'.</li>
      <li>Blank is Return JSON. Patterns is "txt"/'return shorturl', "json"/'return json style. this default', "xml"/'return xml style'./li>
    </ol>
  </section>
</article>
  