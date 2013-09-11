/*
 * WordFlow.net Simple Modal Window Plugin
 * 
 * Turns divs into modal windows easily. 
 *
 */

(function(window, document, undefined){
	
	var modalWindow = {
		
		init: function(options, element) {

			var self = this;

			// hide all the elements with a class of .modal or whatever was passed by default.
			// other than hiding the elements the self.elem is worthless..

			self.elem = $(element).hide();

			self.options = $.extend({}, $.fn.modalWindow.options, options);

			self.openButton = $(self.options.openButton);

			self.closeButton = $(self.options.closeButton);

			self.attr = self.openButton.attr('href');

			self.modal = $(self.attr).hide();

			self.listenForClicks();

		},

		listenForClicks: function() {

			var self = this;

			self.openButton.on('click', function(event){

				event.preventDefault();

				self.modal.toggle();

			});

			self.closeButton.on('click', function(event){

				event.preventDefault();

				self.modal.toggle();

			});

		}
	
	};
	
	$.fn.modalWindow = function(options){
		return this.each(function(){
			
			var obj = Object.create(modalWindow);
			
			obj.init(options, this);
			
		});	
	};
	
	$.fn.modalWindow.options = {
		openButton: '.open-modal',
		closeButton:'.close-modal'
	};

}(window, document));