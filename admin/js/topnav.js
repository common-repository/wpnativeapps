function addTopNavHamburgerItem(el){
	var maxitem = 20;

			var section = $(el).parents('section.navStructureRow');
			var pagecount = $(el).parents('.topNavPageSettings').attr('data-pagecount');
			var structureCount = $(el).parents('.navStructureRow').attr('data-structure');
			var navItemsCount = parseInt($(section).find('.topNavPageIconItem').length);

			var newIconHtml = $('#topNavNaviagionHamburgerItemGeneric').html();
			newIconHtml = newIconHtml.replaceAll('{{iconCount}}',navItemsCount+1).replaceAll('{{topNavTabCount}}',pagecount).replaceAll('{{structureCount}}',structureCount);
			if(navItemsCount >=1){
				var removeIcon = '<span class="button removeNavigationIconRow" onclick="removeTopNavigationIconForHamburger(this);">Remove</span>';
			}else{
				var removeIcon = '';
			}
			
			if(navItemsCount < maxitem){
				$(section).find('span.removeNavigationIconRow').remove();
				$(el).parent().before('<div class="flex-column topNavPageIconItem">'+newIconHtml+'</div>'+removeIcon);
				$('select#topNav_'+parseInt(pagecount)+'_logoLeftBurgerRight_hamburgerNavItem_'+parseInt(navItemsCount+1)+'_endFlowUrl').select2({placeholder: 'Select an option'});
			}
			
			if(navItemsCount < (maxitem-1) ){
				$(section).find('div.addNewNavigationIcon').removeClass('hide');
			}else{
				$(section).find('div.addNewNavigationIcon').addClass('hide');
			}




}
function removeTopNavigationIconForHamburger(el){
	$=jQuery;
	var section = $(el).parents('section.navStructureRow');

	var count = parseInt($(section).find('.topNavPageIconItem').length);
	// console.log(count);
	// if(count >= 1){
		if(confirm("Do you want to remove this?")){
			$(section).find('.topNavPageIconItem:nth('+(count-1)+')').remove()
			// $(removeel).remove();
			$(section).find('.addNewNavigationIcon').removeClass('hide');
			console.log(count);
			if(count == 2){
					$(section).find('span.removeNavigationIconRow').remove();
			}
		}

	// }
}

// When Page is slected from dropdown, copy the page name to Label input.
	$(document).on('change','select.topNavItemUrlInternal',function(){
		var pageName = $(this).find(":selected").text();
		const section = $(this).parents('.topNavPageIconItem');
		section.find('input.topNavItemLabel').val(pageName);
	});
	
