jQuery('body').on('click','.item-delete', function(e){
	if( !confirm('Are you sure you want to delete this item?') )
		e.preventDefault();
});