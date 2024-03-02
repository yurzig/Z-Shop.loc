// <html>
// <head>
//     <meta name="viewport" content="width=device-width, initial-scale=1">
//         <script
//             type="text/javascript"
//             src="https://code.jquery.com/jquery-1.9.1.js"
//         ></script>
//         <script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
//         <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
//             <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.0/select2.min.js"></script>
//             <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.0/select2.css">
// </head><!-- w    ww  .   d e  m    o 2 s    .  c  o  m-->
// <body>
// <input type="hidden" id="tags" style="width: 300px"/>
// <script type='text/javascript'>
//     var lastResults = [];
//     $("#tags").select2({
//     multiple: true,
//     placeholder: "Please enter tags",
//     tokenSeparators: [","],
//     initSelection : function (element, callback) {
//     var data = [];
//     $(element.val().split(",")).each(function () {
//     data.push({id: this, text: this});
// });
//     callback(data);
// },
//     ajax: {
//     multiple: true,
//     url: "/echo/json/",
//     dataType: "json",
//     type: "POST",
//     data: function (term, page) {
//     return {
//     json: JSON.stringify({results: [{id: "foo", text:"foo"},{id:"bar", text:"bar"}]}),
//     q: term
// };
// },
//     results: function (data, page) {
//     lastResults = data.results;
//     return data;
// }
// },
//     createSearchChoice: function (term) {
//     var text = term + (lastResults.some(function(r) { return r.text == term }) ? "" : " (new)");
//     return { id: term, text: text };
// },
// });
//     $('#tags').on("change", function(e){
//     if (e.added) {
//     if (/ \(new\)$/.test(e.added.text)) {
//     var response = confirm("Do you want to add the new tag "+e.added.id+"?");
//     if (response == true) {
//     console.log("Will now send new tag to server: " + e.added.id);
//     /*
//      $.ajax({
//          type: "POST",
//          url: '/someurl&action=addTag',
//          data: {id: e.added.id, action: add},
//          error: function () {
//             console.log("error");
//          }
//       });
//      */
// } else {
//     console.log("Removing the tag");
//     var selectedTags = $("#tags").select2("val");
//     var index = selectedTags.indexOf(e.added.id);
//     selectedTags.splice(index,1);
//     if (selectedTags.length == 0) {
//     $("#tags").select2("val","");
// } else {
//     $("#tags").select2("val",selectedTags);
// }
// }
// }
// }
// });
// </script>
// </body>
// </html>
//
// Чтобы включить множественный выбор с тегами в Select2 версии 4.0, вы можете использовать следующий код. Во-первых, ваша HTML-форма включает необходимый идентификатор для генерации массива:
//
//     <form id="tagForm">
//         <!-- Other form elements -->
//
//         <!-- Dropdown with multiple selections using Select2 -->
//         <select id="choose_usr_email" name="choose_usr_email[]" multiple="multiple" style="width: 300px;"></select>
//
//         <!-- Other form elements -->
//
//         <input type="submit" value="Submit">
//     </form>
// Теперь инициализируйте Select2 с соответствующими настройками в вашем JavaScript:
//
// $(document).ready(function() {
// // Initialize Select2
// $('#choose_usr_email').select2({
//     tags: true, // Automatically creates tags when users hit space or comma
//     tokenSeparators: [",", " "], // Specify token separators
//     ajax: {
//         url: "time.php",
//         dataType: 'json',
//         data: function(term, page) {
//             return {
//                 q: term,
//                 page: page
//             };
//         },
//         results: function(data, page) {
//             return {
//                 results: data
//             };
//         }
//     }
// });
//
// // Handle form submission
// $('#tagForm').submit(function(e) {
//     e.preventDefault();
//     $.ajax({
//         url: "file.php",
//         type: 'POST', // Uncomment this line if you want to use $_POST in PHP
//         dataType: 'json',
//         data: $('#tagForm').serialize(),
//         success: function(response) {
//             // Handle server response
//         }
//     });
// });
// });
// В этом коде choose_usr_email[] идентификатор позволяет создавать массив тегов при отправке. Параметр tokenSeparators указывает символы, которые запускают создание тега (в данном случае, запятую или пробел). Настройки AJAX включены для динамического извлечения данных.
//
// Убедитесь, что у вас есть соответствующий PHP-скрипт (file.php в этом примере) для обработки выбранных значений на стороне сервера.
//
// Эта реализация позволяет пользователям выбирать несколько элементов, включая возможность добавлять пользовательские теги, и отправляет выбранные значения в виде массива.
