<p> diagram of app see in file <b>app-work-flow.png</b></p>
<p>app contains docker file</p>
<p>you can subscribe by url http://localhost/api/subscribe via <b>post</b> method by using <b>url</b> and <b>email</b> params</p>
<p><b>php artisan app:detect-advert-price-changes</b> - command for launch price detection</p>
<p><b>AdvertPriceChangesDetector</b> service runs inside command for changes detection</p>
<p>Current service uses <b>PriceDetector</b> service that parses olx advert page by url</p>
<p>After change detection implemented sending mail inside AdvertPriceChangesDetector</p>
