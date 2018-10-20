var TASKS = (function($, TASKS) {
    var init = function() {
        var request;

        $("#taskForm").submit(function() {
            event.preventDefault();

            if (request) {
                request.abort();
            }

            var $form = $(this);

            var $inputs = $form.find('input');
            
            var serializedData = $form.serialize();

            $.each($form.find('input[type=checkbox]')
                .filter(function() {
                    return $(this).prop('checked') === false
                }),
                function(idx, el) {
                    var emptyVal = 'false';
                    serializedData += '&' + $(el).attr('name') + '=' + emptyVal;
                }
            );

            $inputs.prop('disabled', true);

            request = $.ajax({
                type: 'POST',
                url: 'TaskServiceHandler.php',
                data: serializedData
            });

            request.done(function(response) {
                console.log('done! response:');
                console.log(response);
                $('#output').html(response);
            });

            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                console.error('The following error occurred: ' +
                                textStatus, errorThrown);
                $('#output').html('Bummer: there was an error!');
            });

            request.always(function() {
                $inputs.prop('disabled', false);
            });
        });
    };

    TASKS.form = {
        init: init
    };

    return TASKS;

}(jQuery, TASKS || {}));
