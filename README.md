UNDER CONSTRUCTION - Made public for development reasons. Stay tuned!

# Mimoto
Realtime fluid data management by _Sebastian Kersten_ 

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).


## Definitions

`Mimoto` = data

`Aimless` = presenting that data _(render and realtime)_


## Features

Mimoto is typecasted


## Experiments

* [Cache article](http://maidoprojects/memcache)
* [View all articles in cache](http://maidoprojects/memcachemonitor/article)


## Some Aimless stuff

> This will be explained later

##### onUpdate

* data-mimoto-id
* data-mimoto-value

##### onCreated

* data-mimoto-contains
* data-mimoto-filter


## Actions

    {
        "trigger": "project.updated",
        "service": "Aimless",
        "request": "dataUpdate",
        "type": "async",
        "config":
        {
            "properties":
            [
                "name", 
                "description",

                "client.name", 
                "agency.name", 
                "projectmanager.name",

                "subprojects"
            ]
        }
    }


## Configurating Mimoto.Aimless_backup_201611161715.js

Custom events

```javascript
var sEvent = 'project.*.added';
Mimoto.Aimless.subscribe(sEvent, doSomethingOnAdd);

function doSomethingOnAdd(data)
{
    // do something custom
}
```



## Using forms

```
public function addForm($sFormName, $xData = null, $options = null)
{

    // optional:
    // $sKey, $sFormName, $data, $sLayout = null, $sComponentName = null
    
    // default
    $sKey = (!empty($options) && !empty($options['key'])) ? $options['key'] : self::PRIMARY_FORM;
    
    // store
    $this->_aFormConfigs[$sKey] = (object) array(
        'sFormName' => $sFormName,
        'xData' => $xData,
        'sLayout' => (!empty($options) && !empty($options['layout'])) ? $options['layout'] : '',
        'sTheme' => (!empty($options) && !empty($options['theme'])) ? $options['theme'] : '',
        'options' => $options
    );
```

## Textline features

```
<div class="form-component">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Mimoto.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--validating">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Mimoto.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--validated">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"><svg class="form-component-title-icon-svg"><use xlink:href='#checkmark'/></svg></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Mimoto.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--has-error">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"><span class="form-component-title-icon"><svg class="form-component-title-icon-svg"><use xlink:href='#checkmark'/></svg></span></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Mimoto.value() }}" />
        <p class="form-component-element-error">De tekst bevat ongeldige tekens, alleen cijfers en letters zijn toegestaan.</p>
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>
```

## Using forms

Create a new form with the form editor in `/mimoto.cms` and use the name of that form to show it.

```
Example form layout met cancel en submit

En hoe dit te connecten in een controller
```


## feature wishlist

- Grouping of components by using `/` in the name or by using a grouping entity/mechanism


## Form field settings #todo

```
if ($field->typeOf(CoreConfig::MIMOTO_FORM_INPUT))
            {
                $sRenderedForm .= '<script>Mimoto.form.registerInputField("'.$field->getAimlessId().'")</script>';

                // <script>Mimoto.form.registerInputField('{{ name }}'{% if validation is not empty %}, {{ validation }}{% endif %})</script>
                //  een field heeft settings:

                // _mimoto_inputfield
                // _mimoto_inputfieldsetting
            }
```


## Radiobutton features

```

<div class="form-component">
  <p class="form-component-title">Is dit een radiobutton? <span class="form-component-title-information">(optioneel)</span></p>

  <div class="form-component-content form-component-content--no-description">
    <div class="form-component-element">
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="yes" class="form-radiobutton"/>
        <label for="yes" class="form-component-element-label">Ja, maar alleen vandaag</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="maybe" class="form-radiobutton"/>
        <label for="maybe" class="form-component-element-label">Misschien wel</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="no" class="form-radiobutton"/>
        <label for="no" class="form-component-element-label">Waarschijnlijk niet</label>
      </div>
    </div>
  </div>
</div>

<div class="form-component">
  <p class="form-component-title">Is dit een radiobutton? <span class="form-component-title-information">(optioneel)</span><span class="js-form-component-title-icon form-component-title-icon icon icon-loading"></span></p>

  <div class="form-component-content">
    <div class="form-component-element">
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="yes" class="form-radiobutton"/>
        <label for="yes" class="form-component-element-label">Ja, maar alleen vandaag</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="maybe" class="form-radiobutton"/>
        <label for="maybe" class="form-component-element-label">Misschien wel</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="no" class="form-radiobutton"/>
        <label for="no" class="form-component-element-label">Waarschijnlijk niet</label>
      </div>
    </div>
    <p class="form-component-description">Kies één van de opties</p>
  </div>
</div>

<div class="form-component form-component--is-validated">
  <p class="form-component-title">Is dit een radiobutton? <span class="form-component-title-information">(optioneel)</span><span class="js-form-component-title-icon form-component-title-icon icon icon-checkmark"></span></p>

  <div class="form-component-content form-component-content--no-description">
    <div class="form-component-element">
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="yes" class="form-radiobutton"/>
        <label for="yes" class="form-component-element-label">Ja, maar alleen vandaag</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="maybe" class="form-radiobutton"/>
        <label for="maybe" class="form-component-element-label">Misschien wel</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="no" class="form-radiobutton"/>
        <label for="no" class="form-component-element-label">Waarschijnlijk niet</label>
      </div>
    </div>
  </div>
</div>

<div class="form-component form-component--has-error">
  <p class="form-component-title">Is dit een radiobutton? <span class="form-component-title-information">(optioneel)</span><span class="js-form-component-title-icon form-component-title-icon icon icon-warning"></span></p>

  <div class="form-component-content form-component-content--no-description">
    <div class="form-component-element">
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="yes" class="form-radiobutton"/>
        <label for="yes" class="form-component-element-label">Ja, maar alleen vandaag</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="maybe" class="form-radiobutton"/>
        <label for="maybe" class="form-component-element-label">Misschien wel</label>
      </div>
      <div class="form-component-element-container">
        <input type="radio" name="radiobutton" id="no" class="form-radiobutton"/>
        <label for="no" class="form-component-element-label">Waarschijnlijk niet</label>
      </div>
      <p class="form-component-element-error">U moet één van de waardes kiezen.</p>
    </div>
  </div>
</div>
```

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
- Complexe datastructuren worden goedkoop
- De prijs van complexiteit daalt!



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