$(document).ready(function() {
    let $form = $('#dates-form'),
        $formResult = $('#dates-form .form-result'),
        $formResultMessage = $('#dates-form .form-result .message'),
        setErrorMessage = (message) => {
            if (!$formResult.hasClass('error')) {
                $formResult.addClass('error');
            }

            $formResultMessage.text(message);
        },
        setSuccessMessage = (message) => {
            if ($formResult.hasClass('error')) {
                $formResult.removeClass('error');
            }

            $formResultMessage.text(message);
        },
        validateInput = () => {
            let isValid = $('#dates').inputmask('isComplete');

            if (!isValid) {
                setErrorMessage('Please Fill Dates Correctly');
            }

            return isValid;
        };

    $('#dates').inputmask("9999/99/99 - 99.99.9999", {
        "placeholder": "YYYY/mm/dd - mm.dd.YYYY",
        isComplete: function(buffer, opts) {
            setSuccessMessage('');

            let value = buffer.join('').split('-'),
                leftValue = value[0].trim(),
                rightValue = value[1].trim(),
                isValidLeft = false,
                isValidRight = false;

            if (leftValue !== "YYYY/mm/dd") {
                isValidLeft = Inputmask.isValid(leftValue, { alias: "datetime", inputFormat: "yyyy/mm/dd"})
            }

            if (rightValue !== "mm.dd.YYYY") {
                isValidRight = Inputmask.isValid(rightValue, { alias: "datetime", inputFormat: "mm.dd.yyyy"});
            }

            return isValidLeft && isValidRight;
        }
    });

    $('#dates-form').submit(function( event ) {
        event.preventDefault();
        if (validateInput()) {
            this.submit();
        }
    });

    $('#ajax').click(function( event ) {
        event.preventDefault();
        if (validateInput()) {
            $.ajax({
                dataType: 'json',
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize()
            }).done(function(result) {
                if (typeof result['error'] !== 'undefined') {
                    setErrorMessage(result['error']);
                }

                if (typeof result['result'] !== 'undefined') {
                    setSuccessMessage(result['result']);
                }
            }).fail(function(error) {
                $formResult.addClass('error');
                $formResultMessage.text('Server Runtime Error');
            });
        }
    });
});