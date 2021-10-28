$("#addhabit").click(function(){
    Swal.fire({
        title: 'Add Habit',
        showDenyButton: false,
        showCancelButton: true,
        html:"<form action='#'><div class='mdl-textfield mdl-js-textfield mdl-textfield--floating-label'><input class='mdl-textfield__input' type='text' id='sample3'><label class='mdl-textfield__label' for='sample3'>Text...</label></div></form>",
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          Swal.fire('Saved!', '', 'success')
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })
});



setTimeout(
  function() 
  {
    
$("#habitloader").hide();
$("#habits").show();
  }, 2000);


  $(function(){
    function selectDate(date) {
      $('.calendar-container').updateCalendarOptions({
        date: date
      });
    }
    
    var defaultConfig = {
      weekDayLength: 1,
      date: new Date(),
      onClickDate: selectDate,
      showYearDropdown: true,
    };
    
    $('.calendar-container').calendar(defaultConfig);
  
    });
    
   