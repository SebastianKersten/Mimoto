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

* Show article in single template - [view](http://maidoprojects/example1)
* Show article in template depending on article 'type' - [view](http://maidoprojects/example2)
* Article feed shows list of existing articles - [view](http://maidoprojects/example3)
http://maidoprojects/example4 - Article feed shows list of existing articles in template depending on article 'type'
http://maidoprojects/example5 - Show project with a list of all it's subprojects
http://maidoprojects/example6 - Show project with a list of all it's subprojects, each connected to a template bases on subproject 'phase'
http://maidoprojects/example7 - Show project with a list of all it's subprojects, each connected to a template bases on and grouped by subproject 'phase'


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