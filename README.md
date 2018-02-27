# letmebot
Telegram (inline) bot that provides direct search links (similar to LMGTFY) for various search engines (ddg, google, bing, ...)

## Installation / Setup
I don't see a point in this, but hey, here are the steps:
1) Get yourself a PHP hoster with HTTPS support (uberspace.de is a good place to start)
2) Get yourself a bot account. To do so, contact [@botfather](https://t.me/botfather), send him `/newbot` and follow the steps until you get a message with an access token looking like this: `123456789:AAABBBCCCDDDEEE000111222333444`. Also make sure to use `/setinline` to enable Inline queries for this bot.
3) Upload the file to your hosters servers, so that it is available via the Web (e.g. on uberspace: upload it to some place at `~/html/`). Test if cou can reach it from your webbrowser via https (e.g. `https://youruser.kurt.uberspace.de/yourfilename.php`). If it is, remember this URL.
4) Setup the webhook: Again in your browser, enter this url: `https://api.telegram.org/bot<YOURTOKEN>/setWebhook?url=<YOUR_SCRIPT_URL>`. Replace `<YOURTOKEN>` with the long token you received from botfather in step 2. Replace `<YOUR_SCRIPT_URL>` with the URL of your script from step 3. Remember to include the `https://`, or Telegram will reject it. Press enter when you are finished. You should get a happy JSON without error messages as the result if it worked.
5) Voila, your setup should be finished. Enjoy your stupid bot. And remember: Never do stuff that should work in PHP.
