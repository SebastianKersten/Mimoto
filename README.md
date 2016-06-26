# Mimoto.Aimless
Realtime fluid data management by _Sebastian Kersten_ 

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).


## Documentation

https://docs.google.com/document/d/1gQeynyg3Yt-x7OT8Zl4_k40ePzvpf3LInOwLm5uTxdM

> Ask for viewing permission! (expectation management: not nearly close to being finished)


## Projects in development

| Project         | Description   |
| --------------- |------------- |
| Maido.Projects  | A project management tool |
| Momkai.com      | Momkai's new portfolio website |
| Speakers agency | A tool for managing speaker requests for De Correspondent |


## Examples

* **Example 1** - Show article in single template - [view](http://maidoprojects/example1)
* **Example 2** - Show article in template depending on article 'type' - [view](http://maidoprojects/example2)
* **Example 3** - Article feed shows list of existing articles - [view](http://maidoprojects/example3)
* **Example 4** - Article feed shows list of existing articles in template depending on article 'type' - [view](http://maidoprojects/example4)
* **Example 5** - Show project with all it's subprojects - [view](http://maidoprojects/example5)
* **Example 6** - Show project with all it's subprojects, each connected to a template bases on subproject 'phase' - [view](http://maidoprojects/example6)
* **Example 7** - Show project with all it's subprojects, each connected to a template bases on and grouped by subproject 'phase' - [view](http://maidoprojects/example7)


## Experiments

http://maidoprojects/memcache - Cache article
http://maidoprojects/memcachemonitor/article - View all articles in cache



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