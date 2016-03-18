# Maido.Projects
A project management tool by _Sebastian Kersten_

This project uses **Aimless**, an _Entity Oriented Programming_ protocol, for creating a live updating interface (with the help of Pusher).

##### onUpdate

* mls_id
* mls_template
* mls_value

##### onCreated

* mls_container
* mls_childtemplate


## Actions

```{
    
    "trigger": "client.updated", // single event
    "trigger": ["client.updated", "agency.updated"], // multiple events
    "trigger": "*.updated", // multiple events with wildcard
    "service": "LiveScreenService",
    "request": "dataUpdate",
    "config":
    {
        "mapping":  
        [
            {
                "property": "Name",
                "valueName": "name"
            }
        ]
    }
}```
