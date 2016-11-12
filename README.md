UNDER CONSTRUCTION - Made public for development reasons. Stay tuned!

# Mimoto.Aimless
Realtime fluid data management by _Sebastian Kersten_ 

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).


## Definitions

`Mimoto` = data

`Aimless` = presenting that data _(render and realtime)_

## Documentation

https://docs.google.com/document/d/1gQeynyg3Yt-x7OT8Zl4_k40ePzvpf3LInOwLm5uTxdM

> Ask for viewing permission! (expectation management: not nearly close to being finished)


## Projects in development

| Project         | Description   |
| :--------------- | :------------- |
| Maido.Projects  | A project management tool |
| Momkai.com      | Momkai's new portfolio website |
| Speakers agency | A tool for managing speaker requests for De Correspondent |


## Examples

* **Example 1** - Show article in single template - [view](http://maidoprojects/example1)
* **Example 2** - Show article in template depending on article 'type' - [view](http://maidoprojects/example2)
* **Example 3** - Article feed shows list of existing articles - [view](http://maidoprojects/example3)
* **Example 4** - Article feed shows list of existing articles in template depending on article 'type' - [view](http://maidoprojects/example4)
* **Example 5** - Show project with all it's subprojects - [view](http://maidoprojects/example5)
* **Example 6** - Show project with all it's subprojects, each connected to a template based on subproject 'phase' - [view](http://maidoprojects/example6)
* **Example 7** - Similar to example 6, but now also grouped by subproject 'phase' - [view](http://maidoprojects/example7)
* **Example 8** - An overview of all clients - *use with examples 9 and 10 for realtime effect* - [view](http://maidoprojects/example8)
* **Example 9** - Changes some values of a client - *use with example 8 for realtime effect* - [view](http://maidoprojects/example9)
* **Example 10** - Create a new client - *use with example 8 for realtime effect* - [view](http://maidoprojects/example10)
* **Example 11** - An overview of all subprojects - *use with examples 12 and 13 for realtime effect* - [view](http://maidoprojects/example11)
* **Example 12** - Toggle subproject phase to 'archived' - *use with example 11 for realtime effect* - [view](http://maidoprojects/example12)
* **Example 13** - Toggle subproject phase to 'currentproject' - *use with example 11 for realtime effect* - [view](http://maidoprojects/example13)
* **Example 14** - Project with subprojects, with value formatter - *use with examples 15 and 16 for realtime effect* - [view](http://maidoprojects/example14)
* **Example 15** - Add subprojects to project's collection - *use with example 14 for realtime effect* - [view](http://maidoprojects/example15)
* **Example 16** - Remove subproject from project's collection - *use with example 14 for realtime effect* - [view](http://maidoprojects/example16)
* **Example 17** - Project with subprojects - typed - *use with examples 18 and 19 for realtime effect* - [view](http://maidoprojects/example17)
* **Example 18** - Add subprojects to project's collection - *use with examples 17 or 20 for realtime effect* - [view](http://maidoprojects/example18)
* **Example 19** - Remove subproject from project's collection - *use with examples 17 or 20 for realtime effect* - [view](http://maidoprojects/example19)
* **Example 20** - Project with subprojects - typed and grouped - *use with examples 18 and 19 for realtime effect* - [view](http://maidoprojects/example20)
* **Example 21** - A 'client' form with a basic textfield - [view](http://maidoprojects/example21)
* **Example 15** - SendGrid

* **Example form 1** - A form with all types of components - [view](http://mimoto.aimless/exampleform1)
* **Example form 2** - A simple form with a connected textfield - [view](http://mimoto.aimless/exampleform2)


## Experiments

* [Cache article](http://maidoprojects/memcache)
* [View all articles in cache](http://maidoprojects/memcachemonitor/article)


## Some Aimless stuff

> This will be explained later

##### onUpdate

* mls_id
* mls_template
* mls_value

##### onCreated

* mls_contains
* mls_filter
* mls_template


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


## Configurating Mimoto.Aimless.js

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
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Aimless.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--validating">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Aimless.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--validated">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"><svg class="form-component-title-icon-svg"><use xlink:href='#checkmark'/></svg></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Aimless.value() }}" />
      </div>
      <p class="form-component-element-description">Mag geen scheldwoorden bevatten</p>
    </div>
  </div>

  <div class="form-component form-component--has-error">
    <label for="" class="form-component-title">Campagne naam <span class="form-component-title-icon"><span class="form-component-title-icon"><svg class="form-component-title-icon-svg"><use xlink:href='#checkmark'/></svg></span></span></label>
    <div class="form-component-content">
      <div class="form-component-element">
        <input type="text" class="form-component-element-input" placeholder="" value="{{ Aimless.value() }}" />
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

                // <script>Mimoto.form.registerInputField('{{ name }}'{% if validation is not empty %}, {{ validation|raw }}{% endif %})</script>
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
$app['Mimoto.Log']->notify('A notification', "There is something I would like you to be aware of. No rush!");
$app['Mimoto.Log']->silent('Silent notice', "The configuration is missing a paramater, but we'll do without for now");
$app['Mimoto.Log']->silent('Another silent test', "Does it live update?");
$app['Mimoto.Log']->warn('Some warning', "Something probably needs your attention");
$app['Mimoto.Log']->error('uh-oh, an error', "Your code is broken. Please fix");
```


## Auto counters
Aimless has support for aesy to implement counters for for instance new notifications. In the below example when a notification is created, or a notificatin changes it's state from `open` to `closed`, Aimless will automatically update the counter and even update the presentation of the counter (in this case by hiding the counter when the count hits zero) 

Example:
```
<div id="header_notification_count" class="hidden" mls_count="_MimotoAimless__devtools__notification" mls_filter='{"state":"open"}' mls_config='{"toggleClasses": {"onZero": "hidden"} }'>0</div>
```