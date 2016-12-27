# OpenCart-plugin
Opencart payment plugin for SpicePay.com

Installation:

1. Upload spicepay_opencart1.zip to your server. Upnzip.
2. Copy contents of "admin" and "catalog" folders to "admin" and "catalog" folders of your opencart installation.
3. Go to Admin -> Extensions -> Payments.
4. Find SpicePay in the list. Click "Install".
5. Click "Edit" to set settings.
SpicePay site ID:  add new site on https://www.spicepay.com/tools.php, set in module settings site ID.
Spicepay Callback Secret: - set the same random secret string at when adding site and in opencart2 spicepay module settings. 
Order Status after pay: - Complete
Status: enabled.
Result URL: http://your-site.com/index.php?route=payment/spicepay/callback
Success URL: http://your-site.com/index.php?route=checkout/success
Fail URL: http://your-site.com/index.php?route=checkout/failure

Find more info on https://www.spicepay.com


SpicePay Team