var ItemManager = function(options){
    var config = {
        tabSlug: '',
        tabBtnHtml: '',
        url: '',
        itemType: '',
        lastIndex: 0,
        targets: {
            parentBlock: '[add-new-item]',
            newItem: '.add',
            removeItem: '[remove-item]',
            loadDetails: '[data-load-box-item-details]'
        }
    };
    var fixedConfig = {};

    function configure(options){
        if( typeof options == 'object' ) jQuery.extend(true, config, fixedConfig, options);
        else jQuery.extend(true, config, fixedConfig);

        // console.log(config);
    }
    configure(options);

    this.init = function(){
        // prepare();
        observe();
    };

    function prepare(){}
    function observe(){
        jQuery('body').on('click', config.targets.parentBlock + ' ' + config.targets.newItem, addNewItem);
        jQuery('body').on('click', config.targets.removeItem, removeItem);
        jQuery('body').on('change', config.targets.loadDetails, loadItemDetails);
    }

    function removeItem(){
        var parentDiv = jQuery(this).parents('.add_remove_row').first();
        if( confirm('Você tem certeza que quer apagar este item?') ) jQuery(this).parents('#'+parentDiv[0].getAttribute('data-ref-id')).first().remove();
        
        if( jQuery('.dd-list').length > 0 ){
            jQuery.each( jQuery('.dd'), function(){
                update_out(this, this.querySelector(".dd-list-order-result"));
            } );
        }
    }

    function addNewItem(e){
        e.preventDefault();
        var request = new XMLHttpRequest;
        var formData = new FormData;
        var parent = jQuery(this).parents(config.targets.parentBlock).first()[0];

        var itemType = parent.getAttribute('data-item-type');
        var itemName = parent.getAttribute('data-item-name');
        var url = parent.getAttribute('data-item-url');
        var presentationIndex = parent.getAttribute('data-presentation-index');
        var lastIndex = parent.getAttribute('data-item-index');
        var _token = document.querySelector('[name=_token]').value;

        formData.append('_token',_token);
        formData.append('itemName',itemName);
        formData.append('itemType',itemType);
        formData.append('itemCount',lastIndex);
        formData.append('presentationCount',presentationIndex);

        request.open('POST', url);
        request.onload = function(){
            var prevItem = document.querySelector('#block-'+itemName+'-'+lastIndex);
            if( parent.hasAttribute('data-add-target') ) prevItem = parent.parentNode.querySelector( parent.getAttribute('data-add-target') );

            if( prevItem == null ) prevItem = jQuery(e.target).parents('.row').first().prev('.row').first()[0];
            if( prevItem == null ) prevItem = jQuery(e.target).parents('.row').first()[0];

            if( prevItem.nodeName == 'OL' || prevItem.nodeName == 'UL' ) prevItem.insertAdjacentHTML('beforeend',this.responseText);
            else prevItem.insertAdjacentHTML('afterend',this.responseText);


            if( jQuery('.picker-item').length > 0 ){
                var object = jQuery('#block-'+itemName+'-'+lastIndex).length > 0 ? jQuery('#block-'+itemName+'-'+lastIndex) : jQuery('#'+itemName+'-'+lastIndex);
                console.log(object);
                
                jQuery.each(object.find('.picker-item'), function(index, el){
                    var picker = el.querySelector('.icp-dd');
                    jQuery(picker).iconpicker({
                        component: el.querySelector('.iconpicker-component'),
                        templates: {
                            search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
                        }
                    }).on('iconpickerSelected',function(e){
                        el.querySelector('.iconpicker-input').value = e.iconpickerValue;
                    });
                });
            }

            lastIndex++;
            jQuery.each( jQuery('#block-'+itemName+'-'+lastIndex).parent().find('[add-new-item]'), function(idx, el){
                el.setAttribute('data-item-index',lastIndex);
            });
            parent.setAttribute('data-item-index',lastIndex);

            if( jQuery('#block-'+itemName+'-'+lastIndex).find('[render-element]').length > 0 ){
                jQuery.each( jQuery('#block-'+itemName+'-'+lastIndex).find('[render-element]'), function(index, el){
                    jQuery(el).trigger('custom_elements.render');
                });
            }

            if( jQuery('#block-'+itemName+'-'+lastIndex).find('.html5-editor').length > 0 ){
                jQuery.each( jQuery('#block-'+itemName+'-'+lastIndex).find('.html5-editor'), function(index, el){
                    jQuery(el).summernote();
                });
            }
            if( jQuery('#block-'+itemName+'-'+lastIndex).find('.datetime').length > 0 ){
                jQuery.each( jQuery('#block-'+itemName+'-'+lastIndex).find('.datetime'), function(index, el){
                    jQuery(el).datetimepicker({format: 'dd/mm/yyyy hh:ii:ss'});
                });
            }

            if( jQuery('.dd-list').length > 0 ){
                jQuery.each( jQuery('.dd'), function(){
                    update_out(this, this.querySelector(".dd-list-order-result"));
                } );
            }

        };
        request.send(formData);
    }

    function loadItemDetails(){
        var itemType = this.getAttribute('data-item-type');
        var url = this.getAttribute('data-load-url');

        var formData = new FormData;
        var request = new XMLHttpRequest;

        var parent = jQuery(this).parents('[id^="block-'+itemType+'"]').first();

        formData.append('itemType',itemType);
        formData.append('ref',this.value);

        request.open('POST', url, false);
        request.onload = function(){
            confirmed = true;
            if( parent.find('.form-control[name*="[title]"]').first().val() != '' ) confirmed = confirm('Isso irá apagar os dados já inseridos no item, deseja mesmo prosseguir?');
            
            if( confirmed ){
                jQuery.each( JSON.parse(this.responseText), function(idx, el){
                    // console.log('Searching for',idx,'to insert',el);
                    // console.log(parent[0].querySelector('[name*="['+idx+']"]'));
                    updatingFields = parent[0].querySelectorAll('[name*="['+idx+']"]');
                    //checar se o campo é file pra substituir
                    updatingFields.forEach(function(updatingField){
                        if( updatingField.type == 'file' ){
                            var fileParent = updatingField.parentNode;
                            while( !fileParent.classList.contains('fileinput') ) fileParent = fileParent.parentNode;
                            fileParent.querySelector('.fileinput-preview').innerHTML = '';
                            
                            if( updatingField != null ){
                                var image = new Image();
                                image.onload = function(){
                                    fileParent.querySelector('.fileinput-preview').appendChild(this);
                                }
                                // console.log(updatingField.getAttribute('name').replace(/\]$/,'_append]'));
                                // console.log(fileParent.querySelector('[name="'+updatingField.getAttribute('name').replace(/\]$/,'_append]')+'"]'));
                                fileParent.querySelector('[name="'+updatingField.getAttribute('name').replace(/\]$/,'_append]')+'"]').value = el;

                                image.src = baseUrl+'/'+el;
                            }

                        } else if( updatingField != null && updatingField.type != 'hidden' ) {
                            updatingField.value = el;
                            if( updatingField.classList.contains('html5-editor') ) updatingField.parentNode.querySelector('.note-editable').innerHTML = el;
                        } else if( idx == 'icon' ) {
                            updatingField.value = el;
                            var icon = updatingField.parentNode.querySelector('i.fa');
                            jQuery.each( icon.classList, function(classIdx, className){
                                if( className.match(/fa-/) ) {
                                    console.log('Encontro, removeu', className);
                                    icon.classList.remove(className);
                                }
                            } );
                            icon.classList.add(el);
                        }
                    });
                });
            }
        }
        request.send(formData);
    }


}