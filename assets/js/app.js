/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');



$(document).ready(function(){
    $("#first_name").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        // $("#table_body tr").filter(function() {
        //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        // });
        var native = $("#table_body").html();

        $.ajax({
            method: "POST",
            url: "/filter",
            data: {firstName: value},
            dataType: "json",
            success: function (data) {
                if (data == '')
                    return;
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    html += "<tr>\n" +
                        "<th scope=\"row\">" + data[i].id + "</th>\n" +
                        "<td>" + data[i].firstName + "</td>\n" +
                        "<td>" + data[i].lastName + "</td>\n" +
                        "<td>" + data[i].phoneNumbers.join(", ") + "</td>\n" +
                        "</tr>";
                }

                $("#table_body").html(html);

                console.log(data);
            }
        });

        console.log({"value ": value, "eq" :value == ''});
        if (value == "") {
            $("#table_body").html(native);
        }


        console.log(value);
    });
});