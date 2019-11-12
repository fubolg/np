$(document).ready(function() {
    let $formResult = $('#dates-form .form-result'),
        $formResultMessage = $('#dates-form .form-result .message'),
        validateInput = () => {
            let isValid = $('#dates').inputmask('isComplete');

            if (!isValid) {
                $formResult.addClass('error');

                $formResultMessage.text('Please Fill Dates Correctly');
            }

            return isValid;
        };

    $('#dates').inputmask("9999/99/99 - 99.99.9999", {
        "placeholder": "YYYY/mm/dd - mm.dd.YYYY",
        isComplete: function(buffer, opts) {
            if ($formResult.hasClass()) {
                $formResult.removeClass('error');
                $formResultMessage.text('');
            }

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
            let $form = $(this);
            $.ajax({
                dataType: 'json',
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize()
            }).done(function(result) {
                console.log('success',result);
            }).fail(function(error) {
                console.log('fail', error);
            });
        }
    });
});