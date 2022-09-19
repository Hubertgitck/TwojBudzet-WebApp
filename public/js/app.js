
/**
 * Add jQuery Validation plugin method for a valid password
 *
 * Valid passwords contain at least one letter and one number.
 */
$.validator.addMethod('validPassword', function(value, element, param) {
        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Hasło musi posiadać co najmniej jedną literę i cyfrę'
);

$.validator.addMethod( 'namePattern', function( value, element, param ) {
	if ( this.optional( element ) ) {
		return true;
	}
	if ( typeof param === "string" ) {
		param = new RegExp( "^(?:" + param + ")$" );
	}
	return param.test( value );
}, 'Nazwa musi zawierać tylko litery, bez znaków specjalnych' );


//Override default message jQuery validator

jQuery.extend(jQuery.validator.messages, {
    required: "To pole jest wymagane",
    email: "Proszę wpisać poprawny adres e-mail",
    minlength: jQuery.validator.format("Wpisz conajmniej 6 znaków")
});
