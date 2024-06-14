jQuery(document).ready(function ($) {
   $('#pledgeForm').on('submit', function (e) {
      e.preventDefault();

      var formData = new FormData(this);

      $.ajax({
         url: ajax_object.ajax_url,
         type: 'POST',
         data: formData,
         contentType: false,
         processData: false,
         success: function (response) {
            if (response.success) {
               window.location.href = response.data.redirect_url;
            } else {
               alert('There was an error. Please try again.');
            }
         }
      });
   });
});