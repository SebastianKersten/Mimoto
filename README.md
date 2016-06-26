# Mimoto.Aimless
Realtime fluid data management by _Sebastian Kersten_ 

For documentation: https://docs.google.com/document/d/1gQeynyg3Yt-x7OT8Zl4_k40ePzvpf3LInOwLm5uTxdM

In development: Maido.Projects
A project management tool by _Sebastian Kersten_

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).

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