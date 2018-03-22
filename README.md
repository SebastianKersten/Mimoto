*DISCLAIMER* - This project is still very much under construction. Stay _tuned_!


# Mimoto
An ultra fast, fluid and realtime data management microframework 


# Requirements

- composer
- npm
- Mimoto uses Gearman async manager 
- Node JS
- Memcached

# Starting up the realtime feature

Run event worker
```
curl http://mimoto.aimless/mimoto.cms/workers/data
```

Run async worker
```
curl http://mimoto.aimless/mimoto.cms/workers/async
```

Run realtime server script
```
node src/userinterface/Mimoto/realtime.js
```



# Basic instalation

Go to the root of the project and  

```
composer update
```

```
npm install
```

```
cp mimoto.json.dist mimoto.json
```


# Realtime data broadcasting

Fire up the Gearman worker and make sure it keeps running in the background.

```
curl "http://mimoto.aimless/mimoto.cms/workers/data
```



# Archive
```
"jquery": "^3.1.1",
"jquery-ui-dist": "^1.12.1",
```


# About


Mimoto is an _Entity Oriented Programming_ protocol that allows you to easily create a realtime interface.


## Definitions

`Mimoto` = data

`Aimless` = presenting that data _(render and realtime)_


## Features

Mimoto is typecasted


## Debugging tools

Mimoto.CMs has it's built in developer debugging console at `/mimoto.cms/notifications`
This notification Center supports `silent`, `notify`, `warn` and `error`. 

```
Mimoto::service('log')->notify('A notification', "There is something I would like you to be aware of. No rush!");
Mimoto::service('log')->silent('Silent notice', "The configuration is missing a paramater, but we'll do without for now");
Mimoto::service('log')->silent('Another silent test', "Does it live update?");
Mimoto::service('log')->warn('Some warning', "Something probably needs your attention");
Mimoto::service('log')->error('uh-oh, an error', "Your code is broken. Please fix");
```

## Auto counters
Aimless has support for aesy to implement counters for for instance new notifications. In the below example when a notification is created, or a notificatin changes it's state from `open` to `closed`, Aimless will automatically update the counter and even update the presentation of the counter (in this case by hiding the counter when the count hits zero) 

Example:
```
<div id="header_notification_count" class="hidden" data-mimoto-count="_Mimoto_notification" data-mimoto-filter='{"state":"open"}' data-mimoto-config='{"toggleClasses": {"onZero": "hidden"} }'>0</div>
```


## Javascript features
https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset

## Some notes for the website

- But what if soemone already has that value on its screen? That person would miss out on the latest changes. Enter Aimless's realtime feature (configure action rule, per user or group, entity, specific value, delayed) broadcast as webevent.
- Don't program functionality, configure it! Start using actions.
- It's really easy. See this example.
- An open platform - build addons tools utils adapters
- External platforms as services that can be connected / addon
- Complex data structures become cheap
- The price of complexity decreases!



## Packages to add

- "brianlmoon/net_gearman": "dev-master"




--------

Post slug generator, for creating clean urls from titles. 
It works with many languages. 
From: http://php.net/manual/en/function.preg-replace.php
<49> hello at weblap dot ro

<?php 
function remove_accent($str) 
{ 
  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
  return str_replace($a, $b, $str); 
} 

function post_slug($str) 
{ 
  return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), 
  array('', '-', ''), remove_accent($str))); 
} 
?> 

Example: post_slug(' -Lo#&@rem  IPSUM //dolor-/sit - amet-/-consectetur! 12 -- ') 
will output: lorem-ipsum-dolor-sit-amet-consectetur-12
