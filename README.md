# Mimoto.Aimless
Realtime fluid data management by _Sebastian Kersten_ 

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).


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