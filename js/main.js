$(document).ready(function() {
  console.log('GF');
  ensure_removed_selection();
  add_date_pickers();
  listener_contact();
});


function ensure_removed_selection() {
  $('#checkbox-rodo').prop('checked', false);
  $('#checkbox-bezubezpieczenia').prop('checked', false);
  $('#checkbox-firmowe').prop('checked', false);
  $('#checkbox-indywidualne').prop('checked', false);
  $('#checkbox-komunikacja').prop('checked', false);
}

function add_date_pickers() {
  // https://github.com/dbushell/Pikaday
  var i18n = {
    previousMonth: 'Wcześniejszy Miesiąc',
    nextMonth: 'Następny Miesiąc',
    months: [
      'Styczeń',
      'Luty',
      'Marzec',
      'Kwiecień',
      'Maj',
      'Czerwiec',
      'Lipiec',
      'Sierpień',
      'Wrzesień',
      'Październik',
      'Listopad',
      'Grudzień'
    ],
    weekdays: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
    weekdaysShort: ['Nd', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob']
  };

  var birthdayPicker = new Pikaday({
    field: document.getElementById('form-birthdate'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-bezubezpieczenia-jeden'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-bezubezpieczenia-dwa'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-bezubezpieczenia-trzy'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-firmowe-jeden'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-firmowe-dwa'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-firmowe-trzy'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-indywidualne-jeden'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-indywidualne-dwa'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-indywidualne-trzy'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-komunikacja-jeden'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-komunikacja-dwa'),
    i18n
  });
   var formMajatekStart = new Pikaday({
    field: document.getElementById('form-komunikacja-trzy'),
    i18n
  });

  // todo formatowanie i tłumaczenie
}

function listener_contact() {
  $('#form-button').on('click', function() {
    $('.error').css('display', 'none');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: 'send.php',
      data: {
        name: $('#form-name').val(),
        surname: $('#form-surname').val(),
        doc: $('#form-doc').val(),
        machine: $('#form-machine').val(),
        persons: $('#form-persons').val(),
        software: $('#form-software').val(),
        contract: $('#form-contract').val(),
		firmowe: $('#checkbox-firmowe').is(':checked'),
		firmoweMienie: $('#form-firmowe-jeden').val(),
		firmoweOC: $('#form-firmowe-dwa').val(),
		firmoweZycie: $('#form-firmowe-trzy').val(),
		indywidualne: $('#checkbox-indywidualne').is(':checked'),
		indywidualneZycie: $('#form-indywidualne-jeden').val(),
		indywidualneMajatek: $('#form-indywidualne-dwa').val(),
		indywidualneOC: $('#form-indywidualne-trzy').val(),
		komunikacja: $('#checkbox-komunikacja').is(':checked'),
		komunikacjaOC: $('#form-komunikacja-jeden').val(),
		komunikacjaAC: $('#form-komunikacja-dwa').val(),
		komunikacjaAss: $('#form-komunikacja-trzy').val(),
		bezubezpieczenia: $('#checkbox-bezubezpieczenia').is(':checked'),
		bezubezpieczeniaFirma: $('#form-bezubezpieczenia-jeden').val(),
		bezubezpieczeniaIndywidualne: $('#form-bezubezpieczenia-dwa').val(),
		bezubezpieczeniaKomunikacja: $('#form-bezubezpieczenia-trzy').val(),
        email: $('#form-email').val(),
        contactNumber: $('#form-contact-number').val(),
        rodo: $('#checkbox-rodo').is(':checked')
      }
    }).done(function(data) {
      if (data.type == 'error') {
        $.each(data.code, function(k, v) {
          $('.err_' + k)
            .html(v)
            .css('display', 'block');
        });
      } else {
        // $('.kontakt_box_all1').css('display','none');
        // $('.kontakt_box_all2').css('display','block').html(data.code);
      }
    });
  });
}

function toggle(id) {
  $('#' + id).toggle();
  console.log(id);
}
