/*
    Description: In-line post editing
    Version: 1.0.0
    Authors: Amrollah Seifoddini, Matthias Bloch, David Lanyi
*/

	function editPost(postId) {
		jQuery('#post'+postId).attr('contentEditable', 'true');
		jQuery('#posttitle'+postId).attr('contentEditable', 'true');
		jQuery('#editlink'+postId).text('Save');
		jQuery('#editlink'+postId).attr('href', 'javascript:savePost('+postId+');');
		jQuery('#postthumb'+postId).on('click', function() {jQuery("#formthumbfile").click();});
		jQuery('#postthumb'+postId).css('cursor','pointer');
		jQuery('#postthumb'+postId).attr('title','Change thumbnail');
	}

	function savePost(postId) {
		jQuery('#post'+postId).removeAttr('contentEditable');
		jQuery('#posttitle'+postId).removeAttr('contentEditable');
		jQuery('#editlink'+postId).text('Edit In-line');
		jQuery('#editlink'+postId).attr('href', 'javascript:editPost('+postId+');');
		jQuery('#postthumb'+postId).on('click');
		jQuery('#postthumb'+postId).css('cursor','auto');
		jQuery('#postthumb'+postId).removeAttr('title');
		jQuery('#formeditpostid').val(postId);	
		jQuery('#formtitle').val(jQuery('#posttitle'+postId).html());	
		jQuery('#formcontent').val(jQuery('#post'+postId).html());	
		jQuery('#editpostform').submit();
	}

jQuery(document).ready(function($) {

		$('.posttext').on('focus', function() {
			var $this = $(this);
			$this.data('before', $this.html());
			return $this;
		}).on('blur keyup paste', function() {
			var $this = $(this);
			if ($this.data('before') !== $this.html()) {
				$this.data('before', $this.html());
			}
			$('.posttext b').each(function() {
			  $(this).replaceWith('<strong>' + $(this).html() + '</strong>');
			});	
			$('.posttext i').each(function() {
			  $(this).replaceWith('<em>' + $(this).html() + '</em>');
			});	

			return $this;
		});
		
		$('#editpostform').submit(function(event){
		 
		  //disable the default form submission
		  event.preventDefault();
		 
		  //grab all form data  
		  var formData = new FormData($(this)[0]);
		 
		  $.ajax({
			url: '',
			type: 'POST',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
		  });
		  
		  location.reload();
		 
		});});
