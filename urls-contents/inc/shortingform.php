<section id="shortenform">
  <h1>URL Shorting Form</h1>
  <form action="/url-shorting" method="post">
    <ul class='form'>
      <li><label>You want to short URL (Blank NotOK)</label>
        <select name="scheme">
          <option value="">Custom-scheme</option>
          <option value="http://" selected>http://</option>
          <option value="https://">https://</option>
        </select>
        <input type="text" name="longurl" placeholder="You want shorting URL to type to This space">
      </li>
      <li><label>Optional custom shortname (Blank OK)</label>
        <?php echo scheme . '://' . urlsdomain .'/'; ?><input type="text" name="shortname" placeholder="custom">
      </li>
    </ul>
    <input type="submit" value="URL Shorting!"></input>
  </form>
</section>
