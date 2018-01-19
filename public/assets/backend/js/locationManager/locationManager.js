function locationManager(params)
{
	var config = {
		targets : {
			region: '[cep-region]',
			city: '[cep-city]',
			district: '[cep-district]',
		},
		urls:{
			cities: baseUrl+'/ajax/lista-cidades/{region_id}',
			districts: baseUrl+'/ajax/lista-bairros/{city_id}'
		}
	};
	var fixedConfig = {
		parent: ''
	};

    function configure(params){
        if( typeof params == 'object' ) jQuery.extend(true, config, params, fixedConfig);
        else jQuery.extend(true, config, fixedConfig);
    }
    configure(params);

    this.init = function(){
        observe();
    };

    function observe(){
		jQuery('body').on('change', config.targets.region, checkRegionList);
		jQuery('body').on('change', config.targets.city, checkCitiesList);
    }

	function checkRegionList()
	{
		var region_id = this.value;
		config.parent = jQuery(this).parents('.row').first();

		if( typeof region_id == 'undefined' || region_id.trim() == '' ) return;

		loadCitiesList(region_id);
	}
    function checkCitiesList()
    {
    	var city_id = this.value;
    	config.parent = jQuery(this).parents('.row').first();

    	if( typeof city_id == 'undefined' || city_id.trim() == '' ) return;

    	loadDistrictsList(city_id);
    }


	function loadCitiesList(region_id = null)
	{
		jQuery.ajax({
            url: getUrl('cities', {region_id: region_id}),
            type: 'get',
            dataType: 'json',
            success: fillCityListData
        });
    }
    function loadDistrictsList(city_id = null)
    {
    	jQuery.ajax({
    		url: getUrl('districts', {city_id: city_id}),
    		type: 'get',
    		dataType: 'json',
    		success: fillDistrictListData
    	});
    }

    function fillCityListData(response){
		var active_city = jQuery(config.parent).find(config.targets.city).attr('current-value') || null;

		jQuery.each(jQuery(config.parent).find(config.targets.city+' option'), function(index, el){
			jQuery(el).remove();
		});

		var $target = jQuery(config.parent).find(config.targets.city);
		$target.append('<option value="">Selecione...</option>');

		jQuery.each(response, function(index, el){
			if( (active_city == el.id || active_city == el.name) && active_city != null ) $target.append('<option value="'+el.id+'" selected>'+el.name+'</option>');
			else $target.append('<option value="'+el.id+'">'+el.name+'</option>');
		});

		// $target.trigger('change');

		if( active_city != null ) $target.trigger('change');//find('option[value="'+active_city+'"]').prop('selected', true).parent().parent().find('.selection .select2-selection__rendered').html(active_city);
		else $target.find('option').first().prop('selected', true).parent().parent().find('.selection .select2-selection__rendered').html('Selecione...');

    }
    function fillDistrictListData(response){
		var active_district = jQuery(config.parent).find(config.targets.district).attr('current-value') || null;

		jQuery.each(jQuery(config.parent).find(config.targets.district+' option'), function(index, el){
			jQuery(el).remove();
		});

		var $target = jQuery(config.parent).find(config.targets.district);
		$target.append('<option value="">Selecione...</option>');

		jQuery.each(response, function(index, el){
			if( (active_district == el.id || active_district == el.name) && active_district != null ) $target.append('<option value="'+el.id+'" selected>'+el.name+'</option>');
			else $target.append('<option value="'+el.id+'">'+el.name+'</option>');
		});

		// $target.trigger('change');

		if( active_district != null ) $target.trigger('change');//find('option[value="'+active_city+'"]').prop('selected', true).parent().parent().find('.selection .select2-selection__rendered').html(active_city);
		else $target.find('option').first().prop('selected', true).parent().parent().find('.selection .select2-selection__rendered').html('Selecione...');

    }

    function getUrl(index, data){
        if( typeof index == 'undefined' ) throw 'Empty URL index given';
        if( typeof config.urls[index] == 'undefined' ) throw 'Invalid URL index given: '+index;

        var url = config.urls[index];

        if( typeof data != 'undefined' ){
            jQuery.each(data, function(key, value){
                url = url.replace('{'+key+'}', value);
            });
        }

        return url;
    }
}
