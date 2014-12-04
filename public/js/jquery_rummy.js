function Alert() {

    var oldTitle = document.title;

    var msg = "Your turn!";

    var timeoutId = setInterval(function() {

        document.title = document.title == msg ? ' ' : msg;

    }, 1000);

    window.onmousemove = function() {

        clearInterval(timeoutId);

        document.title = oldTitle;

        window.onmousemove = null;

    };

}