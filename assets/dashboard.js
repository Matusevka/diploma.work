(() => {
    'use strict'
    feather.replace({ 'aria-hidden': 'true' })
})()

document.addEventListener("DOMContentLoaded", () => {
    if(document.querySelector('#btn-load-time-tracking') !== null)
    {
        async function get_load_time_tracking()
        {
            let response = await fetch('/admin/load-time-tracking', {
                headers: {
                    Authentication: 'secret'
                }
            });
            return await response.json();
        }

        document.querySelector('#btn-load-time-tracking').onclick = function() {
            document.querySelector('#btn-load-time-tracking').setAttribute('disabled', true);
            get_load_time_tracking().then(text => {
                document.querySelector('#btn-load-time-tracking').removeAttribute('disabled');
                if(text !== '')
                {
                    alert(text.message);
                    document.location.reload();
                }
            });
        };
    }
 
    if(document.querySelector('#btn-load-worklogs') !== null)
    {
        async function get_load_worklogs()
        {
            let response = await fetch('/admin/load-worklogs', {
                headers: {
                    Authentication: 'secret'
                }
            });
            return await response.json();
        }

        document.querySelector('#btn-load-worklogs').onclick = function() {
            document.querySelector('#btn-load-worklogs').setAttribute('disabled', true);
            get_load_worklogs().then(text => {
                document.querySelector('#btn-load-worklogs').removeAttribute('disabled');
                if(text !== '')
                {
                    alert(text.message);
                    document.location.reload();
                }
            });
        };
    }
});