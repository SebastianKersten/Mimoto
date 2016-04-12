<?php

// classpath
namespace MaidoProjects\Config\forms;

// Mimoto classes
use Mimoto\Form\MimotoFormConfig;


/**
 * ClientFormConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ClientFormConfig extends MimotoFormConfig
{
    
    public function __construct()
    {
        
        // 1. connect field to entity
        // 2. set field options
        // 3. regexp on save, live regexp, unique=true (bijv bij property name)
        // 4. field twigs
        // 5. Mimoto.FormService creates, outputs and handles forms
        // 6. mysql form table
        // 7. extends common settings-form waarbij een entity enkel een naam heeft
        
        
        $field = $this->createField('', $sTranslationKey);
        
        field = {
            label: value | translationkey | other value
            type: text -> select from list() with query()
            options: { extends textfieldoptions
                
        }
        
        group: forms
        {
            inputelements [] -> query(childOf(group id))
        }
                
        
        in eerste instantie niet hergebruiken van queries of entities als 'extends'
        
        AbstractInput = {
            
        }
        
        
        Author extends User -> entityid
            indien 'value' vaste waarde (default)
        
        
        
        
        
        
        
        
        User:entity {
            firstname:text, (maxchars=255 = default, )
            lastname:text,
            email:text (maxchars=255 = default, regex="/....@.../i", unique (t.o.v. gelijke entities)
            
            
        }
        
        
        
        
        new object
        extend existing object
        valueText
            simple text
            rich text
            checkbox
            select (radio, single, multiple)
        entity: type=entityid/entityname use hashed ids of string value? (laatste, maar wel uniekcheck)
        collection
        group
        
        
        project:Entity ----- (iets is een entity)
        {
            name:simpleText
            description:richText
            client:Entity ----- (iets bevat een entity)
            agency:Entity (options: optional=true, entityType = id, want in database)
            projectManager:entity (options: entityType
            subprojects:collection (options:allowedTypes='subproject') - connection, want if delete -> drop connection)
        }
                
        
        root-collection (id=0, empty database)
        kan groups, entities bevatten (extenden kan later, niet meteen)
                
                
                
                
                
        
        // MimotoFormService->buildForm('client', $nEntityId);
        
        // int, label, entity property
        // options table: multiple per field possible, zoals inhoud dropdown: query type=client (= entityType)
        // met subfiltering {state='archived'}
        
        // formFieldOptionEntity -> by config!
        
        
        // options
        // =======
        // 1. maxchars
        // 2. regexp
        // 3. options:query client.{*}
        
        
        // build form
        // ----------
        // group
        //   title
        //   description
        //   state: none / collapsed / open
        //   
        
        
        // build form field
        // ----------------
        // label
        // type: dropdown
        // description
        // default: 
        // entity property: client
        
        
        // form show current editors (onFocus)
        // sync by diff
        // 
        
        
        // ===== nieuw dossiermodel op basis van werkversie en publish ipv huidig
        // model
        // =====
        // dossier
        //    titel
        //    subtitel
        //    created
        //    tags[]
        //    owners []
        //    mediaitem
        //        type
        //        settings/options
        //        location (etc)
        //    cards []
        
        // 
        // card
        //    titel
        //    content
        //    subdata [] 
        //    created
        //    owners []
        //    linked articles []
        //    tags[]
        //    
        // - sharedcount per dossier
        // - sharedcount per card
        // - visits per dossier
        // - gelezen per card
        // - loaded in external website (context button)
    }
}
